/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@mapbox/fusspot/lib/index.js":
/*!***************************************************!*\
  !*** ./node_modules/@mapbox/fusspot/lib/index.js ***!
  \***************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";

/**
 * Validators are functions which assert certain type.
 * They can return a string which can then be used
 * to display a helpful error message.
 * They can also return a function for a custom error message.
 */
var isPlainObject = __webpack_require__(/*! is-plain-obj */ "./node_modules/is-plain-obj/index.js");
var xtend = __webpack_require__(/*! xtend */ "./node_modules/xtend/immutable.js");

var DEFAULT_ERROR_PATH = 'value';
var NEWLINE_INDENT = '\n  ';

var v = {};

/**
 * Runners
 *
 * Take root validators and run assertion
 */
v.assert = function(rootValidator, options) {
  options = options || {};
  return function(value) {
    var message = validate(rootValidator, value);
    // all good
    if (!message) {
      return;
    }

    var errorMessage = processMessage(message, options);

    if (options.apiName) {
      errorMessage = options.apiName + ': ' + errorMessage;
    }

    throw new Error(errorMessage);
  };
};

/**
 * Higher Order Validators
 *
 * validators which take other validators as input
 * and output a new validator
 */
v.shape = function shape(validatorObj) {
  var validators = objectEntries(validatorObj);
  return function shapeValidator(value) {
    var validationResult = validate(v.plainObject, value);

    if (validationResult) {
      return validationResult;
    }

    var key, validator;
    var errorMessages = [];

    for (var i = 0; i < validators.length; i++) {
      key = validators[i].key;
      validator = validators[i].value;
      validationResult = validate(validator, value[key]);

      if (validationResult) {
        // return [key].concat(validationResult);
        errorMessages.push([key].concat(validationResult));
      }
    }

    if (errorMessages.length < 2) {
      return errorMessages[0];
    }

    // enumerate all the error messages
    return function(options) {
      errorMessages = errorMessages.map(function(message) {
        var key = message[0];
        var renderedMessage = processMessage(message, options)
          .split('\n')
          .join(NEWLINE_INDENT); // indents any inner nesting
        return '- ' + key + ': ' + renderedMessage;
      });

      var objectId = options.path.join('.');
      var ofPhrase = objectId === DEFAULT_ERROR_PATH ? '' : ' of ' + objectId;

      return (
        'The following properties' +
        ofPhrase +
        ' have invalid values:' +
        NEWLINE_INDENT +
        errorMessages.join(NEWLINE_INDENT)
      );
    };
  };
};

v.strictShape = function strictShape(validatorObj) {
  var shapeValidator = v.shape(validatorObj);
  return function strictShapeValidator(value) {
    var shapeResult = shapeValidator(value);
    if (shapeResult) {
      return shapeResult;
    }

    var invalidKeys = Object.keys(value).reduce(function(memo, valueKey) {
      if (validatorObj[valueKey] === undefined) {
        memo.push(valueKey);
      }
      return memo;
    }, []);

    if (invalidKeys.length !== 0) {
      return function() {
        return 'The following keys are invalid: ' + invalidKeys.join(', ');
      };
    }
  };
};

v.arrayOf = function arrayOf(validator) {
  return createArrayValidator(validator);
};

v.tuple = function tuple() {
  var validators = Array.isArray(arguments[0])
    ? arguments[0]
    : Array.prototype.slice.call(arguments);
  return createArrayValidator(validators);
};

// Currently array validation fails when the first invalid item is found.
function createArrayValidator(validators) {
  var validatingTuple = Array.isArray(validators);
  var getValidator = function(index) {
    if (validatingTuple) {
      return validators[index];
    }
    return validators;
  };

  return function arrayValidator(value) {
    var validationResult = validate(v.plainArray, value);
    if (validationResult) {
      return validationResult;
    }

    if (validatingTuple && value.length !== validators.length) {
      return 'an array with ' + validators.length + ' items';
    }

    for (var i = 0; i < value.length; i++) {
      validationResult = validate(getValidator(i), value[i]);
      if (validationResult) {
        return [i].concat(validationResult);
      }
    }
  };
}

v.required = function required(validator) {
  function requiredValidator(value) {
    if (value == null) {
      return function(options) {
        return formatErrorMessage(
          options,
          isArrayCulprit(options.path)
            ? 'cannot be undefined/null.'
            : 'is required.'
        );
      };
    }
    return validator.apply(this, arguments);
  }
  requiredValidator.__required = true;

  return requiredValidator;
};

v.oneOfType = function oneOfType() {
  var validators = Array.isArray(arguments[0])
    ? arguments[0]
    : Array.prototype.slice.call(arguments);
  return function oneOfTypeValidator(value) {
    var messages = validators
      .map(function(validator) {
        return validate(validator, value);
      })
      .filter(Boolean);

    // If we don't have as many messages as no. of validators,
    // then at least one validator was ok with the value.
    if (messages.length !== validators.length) {
      return;
    }

    // check primitive type
    if (
      messages.every(function(message) {
        return message.length === 1 && typeof message[0] === 'string';
      })
    ) {
      return orList(
        messages.map(function(m) {
          return m[0];
        })
      );
    }

    // Complex oneOfTypes like
    // `v.oneOftypes(v.shape({name: v.string})`, `v.shape({name: v.number}))`
    // are complex ¯\_(ツ)_/¯. For the current scope only returning the longest message.
    return messages.reduce(function(max, arr) {
      return arr.length > max.length ? arr : max;
    });
  };
};

/**
 * Meta Validators
 * which take options as argument (not validators)
 * and return a new primitive validator
 */
v.equal = function equal(compareWith) {
  return function equalValidator(value) {
    if (value !== compareWith) {
      return JSON.stringify(compareWith);
    }
  };
};

v.oneOf = function oneOf() {
  var options = Array.isArray(arguments[0])
    ? arguments[0]
    : Array.prototype.slice.call(arguments);
  var validators = options.map(function(value) {
    return v.equal(value);
  });

  return v.oneOfType.apply(this, validators);
};

v.range = function range(compareWith) {
  var min = compareWith[0];
  var max = compareWith[1];
  return function rangeValidator(value) {
    var validationResult = validate(v.number, value);

    if (validationResult || value < min || value > max) {
      return 'number between ' + min + ' & ' + max + ' (inclusive)';
    }
  };
};

/**
 * Primitive validators
 *
 * simple validators which return a string or undefined
 */
v.any = function any() {
  return;
};

v.boolean = function boolean(value) {
  if (typeof value !== 'boolean') {
    return 'boolean';
  }
};

v.number = function number(value) {
  if (typeof value !== 'number') {
    return 'number';
  }
};

v.plainArray = function plainArray(value) {
  if (!Array.isArray(value)) {
    return 'array';
  }
};

v.plainObject = function plainObject(value) {
  if (!isPlainObject(value)) {
    return 'object';
  }
};

v.string = function string(value) {
  if (typeof value !== 'string') {
    return 'string';
  }
};

v.func = function func(value) {
  if (typeof value !== 'function') {
    return 'function';
  }
};

function validate(validator, value) {
  // assertions are optional by default unless wrapped in v.require
  if (value == null && !validator.hasOwnProperty('__required')) {
    return;
  }

  var result = validator(value);

  if (result) {
    return Array.isArray(result) ? result : [result];
  }
}

function processMessage(message, options) {
  // message array follows the convention
  // [...path, result]
  // path is an array of object keys / array indices
  // result is output of the validator
  var len = message.length;

  var result = message[len - 1];
  var path = message.slice(0, len - 1);

  if (path.length === 0) {
    path = [DEFAULT_ERROR_PATH];
  }
  options = xtend(options, { path: path });

  return typeof result === 'function'
    ? result(options) // allows customization of result
    : formatErrorMessage(options, prettifyResult(result));
}

function orList(list) {
  if (list.length < 2) {
    return list[0];
  }
  if (list.length === 2) {
    return list.join(' or ');
  }
  return list.slice(0, -1).join(', ') + ', or ' + list.slice(-1);
}

function prettifyResult(result) {
  return 'must be ' + addArticle(result) + '.';
}

function addArticle(nounPhrase) {
  if (/^an? /.test(nounPhrase)) {
    return nounPhrase;
  }
  if (/^[aeiou]/i.test(nounPhrase)) {
    return 'an ' + nounPhrase;
  }
  if (/^[a-z]/i.test(nounPhrase)) {
    return 'a ' + nounPhrase;
  }
  return nounPhrase;
}

function formatErrorMessage(options, prettyResult) {
  var arrayCulprit = isArrayCulprit(options.path);
  var output = options.path.join('.') + ' ' + prettyResult;
  var prepend = arrayCulprit ? 'Item at position ' : '';

  return prepend + output;
}

function isArrayCulprit(path) {
  return typeof path[path.length - 1] == 'number' || typeof path[0] == 'number';
}

function objectEntries(obj) {
  return Object.keys(obj || {}).map(function(key) {
    return { key: key, value: obj[key] };
  });
}

v.validate = validate;
v.processMessage = processMessage;

module.exports = v;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/browser/browser-client.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/browser/browser-client.js ***!
  \***********************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var browser = __webpack_require__(/*! ./browser-layer */ "./node_modules/@mapbox/mapbox-sdk/lib/browser/browser-layer.js");
var MapiClient = __webpack_require__(/*! ../classes/mapi-client */ "./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-client.js");

function BrowserClient(options) {
  MapiClient.call(this, options);
}
BrowserClient.prototype = Object.create(MapiClient.prototype);
BrowserClient.prototype.constructor = BrowserClient;

BrowserClient.prototype.sendRequest = browser.browserSend;
BrowserClient.prototype.abortRequest = browser.browserAbort;

/**
 * Create a client for the browser.
 *
 * @param {Object} options
 * @param {string} options.accessToken
 * @param {string} [options.origin]
 * @returns {MapiClient}
 */
function createBrowserClient(options) {
  return new BrowserClient(options);
}

module.exports = createBrowserClient;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/browser/browser-layer.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/browser/browser-layer.js ***!
  \**********************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var MapiResponse = __webpack_require__(/*! ../classes/mapi-response */ "./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-response.js");
var MapiError = __webpack_require__(/*! ../classes/mapi-error */ "./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-error.js");
var constants = __webpack_require__(/*! ../constants */ "./node_modules/@mapbox/mapbox-sdk/lib/constants.js");
var parseHeaders = __webpack_require__(/*! ../helpers/parse-headers */ "./node_modules/@mapbox/mapbox-sdk/lib/helpers/parse-headers.js");

// Keys are request IDs, values are XHRs.
var requestsUnderway = {};

function browserAbort(request) {
  var xhr = requestsUnderway[request.id];
  if (!xhr) return;
  xhr.abort();
  delete requestsUnderway[request.id];
}

function createResponse(request, xhr) {
  return new MapiResponse(request, {
    body: xhr.response,
    headers: parseHeaders(xhr.getAllResponseHeaders()),
    statusCode: xhr.status
  });
}

function normalizeBrowserProgressEvent(event) {
  var total = event.total;
  var transferred = event.loaded;
  var percent = (100 * transferred) / total;
  return {
    total: total,
    transferred: transferred,
    percent: percent
  };
}

function sendRequestXhr(request, xhr) {
  return new Promise(function(resolve, reject) {
    xhr.onprogress = function(event) {
      request.emitter.emit(
        constants.EVENT_PROGRESS_DOWNLOAD,
        normalizeBrowserProgressEvent(event)
      );
    };

    var file = request.file;
    if (file) {
      xhr.upload.onprogress = function(event) {
        request.emitter.emit(
          constants.EVENT_PROGRESS_UPLOAD,
          normalizeBrowserProgressEvent(event)
        );
      };
    }

    xhr.onerror = function(error) {
      reject(error);
    };

    xhr.onabort = function() {
      var mapiError = new MapiError({
        request: request,
        type: constants.ERROR_REQUEST_ABORTED
      });
      reject(mapiError);
    };

    xhr.onload = function() {
      delete requestsUnderway[request.id];
      if (xhr.status < 200 || xhr.status >= 400) {
        var mapiError = new MapiError({
          request: request,
          body: xhr.response,
          statusCode: xhr.status
        });
        reject(mapiError);
        return;
      }
      resolve(xhr);
    };

    var body = request.body;

    // matching service needs to send a www-form-urlencoded request
    if (typeof body === 'string') {
      xhr.send(body);
    } else if (body) {
      xhr.send(JSON.stringify(body));
    } else if (file) {
      xhr.send(file);
    } else {
      xhr.send();
    }

    requestsUnderway[request.id] = xhr;
  }).then(function(xhr) {
    return createResponse(request, xhr);
  });
}

// The accessToken argument gives this function flexibility
// for Mapbox's internal client.
function createRequestXhr(request, accessToken) {
  var url = request.url(accessToken);
  var xhr = new window.XMLHttpRequest();
  xhr.open(request.method, url);
  Object.keys(request.headers).forEach(function(key) {
    xhr.setRequestHeader(key, request.headers[key]);
  });
  return xhr;
}

function browserSend(request) {
  return Promise.resolve().then(function() {
    var xhr = createRequestXhr(request, request.client.accessToken);
    return sendRequestXhr(request, xhr);
  });
}

module.exports = {
  browserAbort: browserAbort,
  sendRequestXhr: sendRequestXhr,
  browserSend: browserSend,
  createRequestXhr: createRequestXhr
};


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-client.js":
/*!********************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-client.js ***!
  \********************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var parseToken = __webpack_require__(/*! @mapbox/parse-mapbox-token */ "./node_modules/@mapbox/parse-mapbox-token/index.js");
var MapiRequest = __webpack_require__(/*! ./mapi-request */ "./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-request.js");
var constants = __webpack_require__(/*! ../constants */ "./node_modules/@mapbox/mapbox-sdk/lib/constants.js");

/**
 * A low-level Mapbox API client. Use it to create service clients
 * that share the same configuration.
 *
 * Services and `MapiRequest`s use the underlying `MapiClient` to
 * determine how to create, send, and abort requests in a way
 * that is appropriate to the configuration and environment
 * (Node or the browser).
 *
 * @class MapiClient
 * @property {string} accessToken - The Mapbox access token assigned
 *   to this client.
 * @property {string} [origin] - The origin
 *   to use for API requests. Defaults to https://api.mapbox.com.
 */

function MapiClient(options) {
  if (!options || !options.accessToken) {
    throw new Error('Cannot create a client without an access token');
  }
  // Try parsing the access token to determine right away if it's valid.
  parseToken(options.accessToken);

  this.accessToken = options.accessToken;
  this.origin = options.origin || constants.API_ORIGIN;
}

MapiClient.prototype.createRequest = function createRequest(requestOptions) {
  return new MapiRequest(this, requestOptions);
};

module.exports = MapiClient;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-error.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-error.js ***!
  \*******************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var constants = __webpack_require__(/*! ../constants */ "./node_modules/@mapbox/mapbox-sdk/lib/constants.js");

/**
 * A Mapbox API error.
 *
 * If there's an error during the API transaction,
 * the Promise returned by `MapiRequest`'s [`send`](#send)
 * method should reject with a `MapiError`.
 *
 * @class MapiError
 * @hideconstructor
 * @property {MapiRequest} request - The errored request.
 * @property {string} type - The type of error. Usually this is `'HttpError'`.
 *   If the request was aborted, so the error was
 *   not sent from the server, the type will be
 *   `'RequestAbortedError'`.
 * @property {number} [statusCode] - The numeric status code of
 *   the HTTP response.
 * @property {Object | string} [body] - If the server sent a response body,
 *   this property exposes that response, parsed as JSON if possible.
 * @property {string} [message] - Whatever message could be derived from the
 *   call site and HTTP response.
 *
 * @param {MapiRequest} options.request
 * @param {number} [options.statusCode]
 * @param {string} [options.body]
 * @param {string} [options.message]
 * @param {string} [options.type]
 */
function MapiError(options) {
  var errorType = options.type || constants.ERROR_HTTP;

  var body;
  if (options.body) {
    try {
      body = JSON.parse(options.body);
    } catch (e) {
      body = options.body;
    }
  } else {
    body = null;
  }

  var message = options.message || null;
  if (!message) {
    if (typeof body === 'string') {
      message = body;
    } else if (body && typeof body.message === 'string') {
      message = body.message;
    } else if (errorType === constants.ERROR_REQUEST_ABORTED) {
      message = 'Request aborted';
    }
  }

  this.message = message;
  this.type = errorType;
  this.statusCode = options.statusCode || null;
  this.request = options.request;
  this.body = body;
}

module.exports = MapiError;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-request.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-request.js ***!
  \*********************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var parseToken = __webpack_require__(/*! @mapbox/parse-mapbox-token */ "./node_modules/@mapbox/parse-mapbox-token/index.js");
var xtend = __webpack_require__(/*! xtend */ "./node_modules/xtend/immutable.js");
var EventEmitter = __webpack_require__(/*! eventemitter3 */ "./node_modules/@mapbox/mapbox-sdk/node_modules/eventemitter3/index.js");
var urlUtils = __webpack_require__(/*! ../helpers/url-utils */ "./node_modules/@mapbox/mapbox-sdk/lib/helpers/url-utils.js");
var constants = __webpack_require__(/*! ../constants */ "./node_modules/@mapbox/mapbox-sdk/lib/constants.js");

var requestId = 1;

/**
 * A Mapbox API request.
 *
 * Note that creating a `MapiRequest` does *not* send the request automatically.
 * Use the request's `send` method to send it off and get a `Promise`.
 *
 * The `emitter` property is an `EventEmitter` that emits the following events:
 *
 * - `'response'` - Listeners will be called with a `MapiResponse`.
 * - `'error'` - Listeners will be called with a `MapiError`.
 * - `'downloadProgress'` - Listeners will be called with `ProgressEvents`.
 * - `'uploadProgress'` - Listeners will be called with `ProgressEvents`.
 *   Upload events are only available when the request includes a file.
 *
 * @class MapiRequest
 * @property {EventEmitter} emitter - An event emitter. See above.
 * @property {MapiClient} client - This request's `MapiClient`.
 * @property {MapiResponse|null} response - If this request has been sent and received
 *   a response, the response is available on this property.
 * @property {MapiError|Error|null} error - If this request has been sent and
 *   received an error in response, the error is available on this property.
 * @property {boolean} aborted - If the request has been aborted
 *   (via [`abort`](#abort)), this property will be `true`.
 * @property {boolean} sent - If the request has been sent, this property will
 *   be `true`. You cannot send the same request twice, so if you need to create
 *   a new request that is the equivalent of an existing one, use
 *   [`clone`](#clone).
 * @property {string} path - The request's path, including colon-prefixed route
 *   parameters.
 * @property {string} origin - The request's origin.
 * @property {string} method - The request's HTTP method.
 * @property {Object} query - A query object, which will be transformed into
 *   a URL query string.
 * @property {Object} params - A route parameters object, whose values will
 *   be interpolated the path.
 * @property {Object} headers - The request's headers.
 * @property {Object|string|null} body - Data to send with the request.
 *   If the request has a body, it will also be sent with the header
 *   `'Content-Type: application/json'`.
 * @property {Blob|ArrayBuffer|string|ReadStream} file - A file to
 *   send with the request. The browser client accepts Blobs and ArrayBuffers;
 *   the Node client accepts strings (filepaths) and ReadStreams.
 * @property {string} encoding - The encoding of the response.
 * @property {string} sendFileAs - The method to send the `file`. Options are
 *   `data` (x-www-form-urlencoded) or `form` (multipart/form-data).
 */

/**
 * @ignore
 * @param {MapiClient} client
 * @param {Object} options
 * @param {string} options.method
 * @param {string} options.path
 * @param {Object} [options.query={}]
 * @param {Object} [options.params={}]
 * @param {string} [options.origin]
 * @param {Object} [options.headers]
 * @param {Object} [options.body=null]
 * @param {Blob|ArrayBuffer|string|ReadStream} [options.file=null]
 * @param {string} [options.encoding=utf8]
 */
function MapiRequest(client, options) {
  if (!client) {
    throw new Error('MapiRequest requires a client');
  }
  if (!options || !options.path || !options.method) {
    throw new Error(
      'MapiRequest requires an options object with path and method properties'
    );
  }

  var defaultHeaders = {};
  if (options.body) {
    defaultHeaders['content-type'] = 'application/json';
  }

  var headersWithDefaults = xtend(defaultHeaders, options.headers);

  // Disallows duplicate header names of mixed case,
  // e.g. Content-Type and content-type.
  var headers = Object.keys(headersWithDefaults).reduce(function(memo, name) {
    memo[name.toLowerCase()] = headersWithDefaults[name];
    return memo;
  }, {});

  this.id = requestId++;
  this._options = options;

  this.emitter = new EventEmitter();
  this.client = client;
  this.response = null;
  this.error = null;
  this.sent = false;
  this.aborted = false;
  this.path = options.path;
  this.method = options.method;
  this.origin = options.origin || client.origin;
  this.query = options.query || {};
  this.params = options.params || {};
  this.body = options.body || null;
  this.file = options.file || null;
  this.encoding = options.encoding || 'utf8';
  this.sendFileAs = options.sendFileAs || null;
  this.headers = headers;
}

/**
 * Get the URL of the request.
 *
 * @param {string} [accessToken] - By default, the access token of the request's
 *   client is used.
 * @return {string}
 */
MapiRequest.prototype.url = function url(accessToken) {
  var url = urlUtils.prependOrigin(this.path, this.origin);
  url = urlUtils.appendQueryObject(url, this.query);
  var routeParams = this.params;
  var actualAccessToken =
    accessToken == null ? this.client.accessToken : accessToken;
  if (actualAccessToken) {
    url = urlUtils.appendQueryParam(url, 'access_token', actualAccessToken);
    var accessTokenOwnerId = parseToken(actualAccessToken).user;
    routeParams = xtend({ ownerId: accessTokenOwnerId }, routeParams);
  }
  url = urlUtils.interpolateRouteParams(url, routeParams);
  return url;
};

/**
 * Send the request. Returns a Promise that resolves with a `MapiResponse`.
 * You probably want to use `response.body`.
 *
 * `send` only retrieves the first page of paginated results. You can get
 * the next page by using the `MapiResponse`'s [`nextPage`](#nextpage)
 * function, or iterate through all pages using [`eachPage`](#eachpage)
 * instead of `send`.
 *
 * @returns {Promise<MapiResponse>}
 */
MapiRequest.prototype.send = function send() {
  var self = this;

  if (self.sent) {
    throw new Error(
      'This request has already been sent. Check the response and error properties. Create a new request with clone().'
    );
  }
  self.sent = true;

  return self.client.sendRequest(self).then(
    function(response) {
      self.response = response;
      self.emitter.emit(constants.EVENT_RESPONSE, response);
      return response;
    },
    function(error) {
      self.error = error;
      self.emitter.emit(constants.EVENT_ERROR, error);
      throw error;
    }
  );
};

/**
 * Abort the request.
 *
 * Any pending `Promise` returned by [`send`](#send) will be rejected with
 * an error with `type: 'RequestAbortedError'`. If you've created a request
 * that might be aborted, you need to catch and handle such errors.
 *
 * This method will also abort any requests created while fetching subsequent
 * pages via [`eachPage`](#eachpage).
 *
 * If the request has not been sent or has already been aborted, nothing
 * will happen.
 */
MapiRequest.prototype.abort = function abort() {
  if (this._nextPageRequest) {
    this._nextPageRequest.abort();
    delete this._nextPageRequest;
  }

  if (this.response || this.error || this.aborted) return;

  this.aborted = true;
  this.client.abortRequest(this);
};

/**
 * Invoke a callback for each page of a paginated API response.
 *
 * The callback should have the following signature:
 *
 * ```js
 * (
 *   error: MapiError,
 *   response: MapiResponse,
 *   next: () => void
 * ) => void
 * ```
 *
 * **The next page will not be fetched until you've invoked the
 * `next` callback**, indicating that you're ready for it.
 *
 * @param {Function} callback
 */
MapiRequest.prototype.eachPage = function eachPage(callback) {
  var self = this;

  function handleResponse(response) {
    function getNextPage() {
      delete self._nextPageRequest;
      var nextPageRequest = response.nextPage();
      if (nextPageRequest) {
        self._nextPageRequest = nextPageRequest;
        getPage(nextPageRequest);
      }
    }
    callback(null, response, getNextPage);
  }

  function handleError(error) {
    callback(error, null, function() {});
  }

  function getPage(request) {
    request.send().then(handleResponse, handleError);
  }
  getPage(this);
};

/**
 * Clone this request.
 *
 * Each request can only be sent *once*. So if you'd like to send the
 * same request again, clone it and send away.
 *
 * @returns {MapiRequest} - A new `MapiRequest` configured just like this one.
 */
MapiRequest.prototype.clone = function clone() {
  return this._extend();
};

/**
 * @ignore
 */
MapiRequest.prototype._extend = function _extend(options) {
  var extendedOptions = xtend(this._options, options);
  return new MapiRequest(this.client, extendedOptions);
};

module.exports = MapiRequest;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-response.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-response.js ***!
  \**********************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var parseLinkHeader = __webpack_require__(/*! ../helpers/parse-link-header */ "./node_modules/@mapbox/mapbox-sdk/lib/helpers/parse-link-header.js");

/**
 * A Mapbox API response.
 *
 * @class MapiResponse
 * @property {Object} body - The response body, parsed as JSON.
 * @property {string} rawBody - The raw response body.
 * @property {number} statusCode - The response's status code.
 * @property {Object} headers - The parsed response headers.
 * @property {Object} links - The parsed response links.
 * @property {MapiRequest} request - The response's originating `MapiRequest`.
 */

/**
 * @ignore
 * @param {MapiRequest} request
 * @param {Object} responseData
 * @param {Object} responseData.headers
 * @param {string} responseData.body
 * @param {number} responseData.statusCode
 */
function MapiResponse(request, responseData) {
  this.request = request;
  this.headers = responseData.headers;
  this.rawBody = responseData.body;
  this.statusCode = responseData.statusCode;
  try {
    this.body = JSON.parse(responseData.body || '{}');
  } catch (parseError) {
    this.body = responseData.body;
  }
  this.links = parseLinkHeader(this.headers.link);
}

/**
 * Check if there is a next page that you can fetch.
 *
 * @returns {boolean}
 */
MapiResponse.prototype.hasNextPage = function hasNextPage() {
  return !!this.links.next;
};

/**
 * Create a request for the next page, if there is one.
 * If there is no next page, returns `null`.
 *
 * @returns {MapiRequest | null}
 */
MapiResponse.prototype.nextPage = function nextPage() {
  if (!this.hasNextPage()) return null;
  return this.request._extend({
    path: this.links.next.url
  });
};

module.exports = MapiResponse;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/constants.js":
/*!**********************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/constants.js ***!
  \**********************************************************/
/***/ ((module) => {

"use strict";


module.exports = {
  API_ORIGIN: 'https://api.mapbox.com',
  EVENT_PROGRESS_DOWNLOAD: 'downloadProgress',
  EVENT_PROGRESS_UPLOAD: 'uploadProgress',
  EVENT_ERROR: 'error',
  EVENT_RESPONSE: 'response',
  ERROR_HTTP: 'HttpError',
  ERROR_REQUEST_ABORTED: 'RequestAbortedError'
};


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/helpers/parse-headers.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/helpers/parse-headers.js ***!
  \**********************************************************************/
/***/ ((module) => {

"use strict";


function parseSingleHeader(raw) {
  var boundary = raw.indexOf(':');
  var name = raw
    .substring(0, boundary)
    .trim()
    .toLowerCase();
  var value = raw.substring(boundary + 1).trim();
  return {
    name: name,
    value: value
  };
}

/**
 * Parse raw headers into an object with lowercase properties.
 * Does not fully parse headings into more complete data structure,
 * as larger libraries might do. Also does not deal with duplicate
 * headers because Node doesn't seem to deal with those well, so
 * we shouldn't let the browser either, for consistency.
 *
 * @param {string} raw
 * @returns {Object}
 */
function parseHeaders(raw) {
  var headers = {};
  if (!raw) {
    return headers;
  }

  raw
    .trim()
    .split(/[\r|\n]+/)
    .forEach(function(rawHeader) {
      var parsed = parseSingleHeader(rawHeader);
      headers[parsed.name] = parsed.value;
    });

  return headers;
}

module.exports = parseHeaders;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/helpers/parse-link-header.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/helpers/parse-link-header.js ***!
  \**************************************************************************/
/***/ ((module) => {

"use strict";


// Like https://github.com/thlorenz/lib/parse-link-header but without any
// additional dependencies.

function parseParam(param) {
  var parts = param.match(/\s*(.+)\s*=\s*"?([^"]+)"?/);
  if (!parts) return null;

  return {
    key: parts[1],
    value: parts[2]
  };
}

function parseLink(link) {
  var parts = link.match(/<?([^>]*)>(.*)/);
  if (!parts) return null;

  var linkUrl = parts[1];
  var linkParams = parts[2].split(';');
  var rel = null;
  var parsedLinkParams = linkParams.reduce(function(result, param) {
    var parsed = parseParam(param);
    if (!parsed) return result;
    if (parsed.key === 'rel') {
      if (!rel) {
        rel = parsed.value;
      }
      return result;
    }
    result[parsed.key] = parsed.value;
    return result;
  }, {});
  if (!rel) return null;

  return {
    url: linkUrl,
    rel: rel,
    params: parsedLinkParams
  };
}

/**
 * Parse a Link header.
 *
 * @param {string} linkHeader
 * @returns {{
 *   [string]: {
 *     url: string,
 *     params: { [string]: string }
 *   }
 * }}
 */
function parseLinkHeader(linkHeader) {
  if (!linkHeader) return {};

  return linkHeader.split(/,\s*</).reduce(function(result, link) {
    var parsed = parseLink(link);
    if (!parsed) return result;
    // rel value can be multiple whitespace-separated rels.
    var splitRel = parsed.rel.split(/\s+/);
    splitRel.forEach(function(rel) {
      if (!result[rel]) {
        result[rel] = {
          url: parsed.url,
          params: parsed.params
        };
      }
    });
    return result;
  }, {});
}

module.exports = parseLinkHeader;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/lib/helpers/url-utils.js":
/*!******************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/lib/helpers/url-utils.js ***!
  \******************************************************************/
/***/ ((module) => {

"use strict";


// Encode each item of an array individually. The comma
// delimiters should not themselves be encoded.
function encodeArray(arrayValue) {
  return arrayValue.map(encodeURIComponent).join(',');
}

function encodeValue(value) {
  if (Array.isArray(value)) {
    return encodeArray(value);
  }
  return encodeURIComponent(String(value));
}

/**
 * Append a query parameter to a URL.
 *
 * @param {string} url
 * @param {string} key
 * @param {string|number|boolean|Array<*>>} [value] - Provide an array
 *   if the value is a list and commas between values need to be
 *   preserved, unencoded.
 * @returns {string} - Modified URL.
 */
function appendQueryParam(url, key, value) {
  if (value === false || value === null) {
    return url;
  }
  var punctuation = /\?/.test(url) ? '&' : '?';
  var query = encodeURIComponent(key);
  if (value !== undefined && value !== '' && value !== true) {
    query += '=' + encodeValue(value);
  }
  return '' + url + punctuation + query;
}

/**
 * Derive a query string from an object and append it
 * to a URL.
 *
 * @param {string} url
 * @param {Object} [queryObject] - Values should be primitives.
 * @returns {string} - Modified URL.
 */
function appendQueryObject(url, queryObject) {
  if (!queryObject) {
    return url;
  }

  var result = url;
  Object.keys(queryObject).forEach(function(key) {
    var value = queryObject[key];
    if (value === undefined) {
      return;
    }
    if (Array.isArray(value)) {
      value = value
        .filter(function(v) {
          return v !== null && v !== undefined;
        })
        .join(',');
    }
    result = appendQueryParam(result, key, value);
  });
  return result;
}

/**
 * Prepend an origin to a URL. If the URL already has an
 * origin, do nothing.
 *
 * @param {string} url
 * @param {string} origin
 * @returns {string} - Modified URL.
 */
function prependOrigin(url, origin) {
  if (!origin) {
    return url;
  }

  if (url.slice(0, 4) === 'http') {
    return url;
  }

  var delimiter = url[0] === '/' ? '' : '/';
  return '' + origin.replace(/\/$/, '') + delimiter + url;
}

/**
 * Interpolate values into a route with express-style,
 * colon-prefixed route parameters.
 *
 * @param {string} route
 * @param {Object} [params] - Values should be primitives
 *   or arrays of primitives. Provide an array if the value
 *   is a list and commas between values need to be
 *   preserved, unencoded.
 * @returns {string} - Modified URL.
 */
function interpolateRouteParams(route, params) {
  if (!params) {
    return route;
  }
  return route.replace(/\/:([a-zA-Z0-9]+)/g, function(_, paramId) {
    var value = params[paramId];
    if (value === undefined) {
      throw new Error('Unspecified route parameter ' + paramId);
    }
    var preppedValue = encodeValue(value);
    return '/' + preppedValue;
  });
}

module.exports = {
  appendQueryObject: appendQueryObject,
  appendQueryParam: appendQueryParam,
  prependOrigin: prependOrigin,
  interpolateRouteParams: interpolateRouteParams
};


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/node_modules/eventemitter3/index.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/node_modules/eventemitter3/index.js ***!
  \*****************************************************************************/
/***/ ((module) => {

"use strict";


var has = Object.prototype.hasOwnProperty
  , prefix = '~';

/**
 * Constructor to create a storage for our `EE` objects.
 * An `Events` instance is a plain object whose properties are event names.
 *
 * @constructor
 * @private
 */
function Events() {}

//
// We try to not inherit from `Object.prototype`. In some engines creating an
// instance in this way is faster than calling `Object.create(null)` directly.
// If `Object.create(null)` is not supported we prefix the event names with a
// character to make sure that the built-in object properties are not
// overridden or used as an attack vector.
//
if (Object.create) {
  Events.prototype = Object.create(null);

  //
  // This hack is needed because the `__proto__` property is still inherited in
  // some old browsers like Android 4, iPhone 5.1, Opera 11 and Safari 5.
  //
  if (!new Events().__proto__) prefix = false;
}

/**
 * Representation of a single event listener.
 *
 * @param {Function} fn The listener function.
 * @param {*} context The context to invoke the listener with.
 * @param {Boolean} [once=false] Specify if the listener is a one-time listener.
 * @constructor
 * @private
 */
function EE(fn, context, once) {
  this.fn = fn;
  this.context = context;
  this.once = once || false;
}

/**
 * Add a listener for a given event.
 *
 * @param {EventEmitter} emitter Reference to the `EventEmitter` instance.
 * @param {(String|Symbol)} event The event name.
 * @param {Function} fn The listener function.
 * @param {*} context The context to invoke the listener with.
 * @param {Boolean} once Specify if the listener is a one-time listener.
 * @returns {EventEmitter}
 * @private
 */
function addListener(emitter, event, fn, context, once) {
  if (typeof fn !== 'function') {
    throw new TypeError('The listener must be a function');
  }

  var listener = new EE(fn, context || emitter, once)
    , evt = prefix ? prefix + event : event;

  if (!emitter._events[evt]) emitter._events[evt] = listener, emitter._eventsCount++;
  else if (!emitter._events[evt].fn) emitter._events[evt].push(listener);
  else emitter._events[evt] = [emitter._events[evt], listener];

  return emitter;
}

/**
 * Clear event by name.
 *
 * @param {EventEmitter} emitter Reference to the `EventEmitter` instance.
 * @param {(String|Symbol)} evt The Event name.
 * @private
 */
function clearEvent(emitter, evt) {
  if (--emitter._eventsCount === 0) emitter._events = new Events();
  else delete emitter._events[evt];
}

/**
 * Minimal `EventEmitter` interface that is molded against the Node.js
 * `EventEmitter` interface.
 *
 * @constructor
 * @public
 */
function EventEmitter() {
  this._events = new Events();
  this._eventsCount = 0;
}

/**
 * Return an array listing the events for which the emitter has registered
 * listeners.
 *
 * @returns {Array}
 * @public
 */
EventEmitter.prototype.eventNames = function eventNames() {
  var names = []
    , events
    , name;

  if (this._eventsCount === 0) return names;

  for (name in (events = this._events)) {
    if (has.call(events, name)) names.push(prefix ? name.slice(1) : name);
  }

  if (Object.getOwnPropertySymbols) {
    return names.concat(Object.getOwnPropertySymbols(events));
  }

  return names;
};

/**
 * Return the listeners registered for a given event.
 *
 * @param {(String|Symbol)} event The event name.
 * @returns {Array} The registered listeners.
 * @public
 */
EventEmitter.prototype.listeners = function listeners(event) {
  var evt = prefix ? prefix + event : event
    , handlers = this._events[evt];

  if (!handlers) return [];
  if (handlers.fn) return [handlers.fn];

  for (var i = 0, l = handlers.length, ee = new Array(l); i < l; i++) {
    ee[i] = handlers[i].fn;
  }

  return ee;
};

/**
 * Return the number of listeners listening to a given event.
 *
 * @param {(String|Symbol)} event The event name.
 * @returns {Number} The number of listeners.
 * @public
 */
EventEmitter.prototype.listenerCount = function listenerCount(event) {
  var evt = prefix ? prefix + event : event
    , listeners = this._events[evt];

  if (!listeners) return 0;
  if (listeners.fn) return 1;
  return listeners.length;
};

/**
 * Calls each of the listeners registered for a given event.
 *
 * @param {(String|Symbol)} event The event name.
 * @returns {Boolean} `true` if the event had listeners, else `false`.
 * @public
 */
EventEmitter.prototype.emit = function emit(event, a1, a2, a3, a4, a5) {
  var evt = prefix ? prefix + event : event;

  if (!this._events[evt]) return false;

  var listeners = this._events[evt]
    , len = arguments.length
    , args
    , i;

  if (listeners.fn) {
    if (listeners.once) this.removeListener(event, listeners.fn, undefined, true);

    switch (len) {
      case 1: return listeners.fn.call(listeners.context), true;
      case 2: return listeners.fn.call(listeners.context, a1), true;
      case 3: return listeners.fn.call(listeners.context, a1, a2), true;
      case 4: return listeners.fn.call(listeners.context, a1, a2, a3), true;
      case 5: return listeners.fn.call(listeners.context, a1, a2, a3, a4), true;
      case 6: return listeners.fn.call(listeners.context, a1, a2, a3, a4, a5), true;
    }

    for (i = 1, args = new Array(len -1); i < len; i++) {
      args[i - 1] = arguments[i];
    }

    listeners.fn.apply(listeners.context, args);
  } else {
    var length = listeners.length
      , j;

    for (i = 0; i < length; i++) {
      if (listeners[i].once) this.removeListener(event, listeners[i].fn, undefined, true);

      switch (len) {
        case 1: listeners[i].fn.call(listeners[i].context); break;
        case 2: listeners[i].fn.call(listeners[i].context, a1); break;
        case 3: listeners[i].fn.call(listeners[i].context, a1, a2); break;
        case 4: listeners[i].fn.call(listeners[i].context, a1, a2, a3); break;
        default:
          if (!args) for (j = 1, args = new Array(len -1); j < len; j++) {
            args[j - 1] = arguments[j];
          }

          listeners[i].fn.apply(listeners[i].context, args);
      }
    }
  }

  return true;
};

/**
 * Add a listener for a given event.
 *
 * @param {(String|Symbol)} event The event name.
 * @param {Function} fn The listener function.
 * @param {*} [context=this] The context to invoke the listener with.
 * @returns {EventEmitter} `this`.
 * @public
 */
EventEmitter.prototype.on = function on(event, fn, context) {
  return addListener(this, event, fn, context, false);
};

/**
 * Add a one-time listener for a given event.
 *
 * @param {(String|Symbol)} event The event name.
 * @param {Function} fn The listener function.
 * @param {*} [context=this] The context to invoke the listener with.
 * @returns {EventEmitter} `this`.
 * @public
 */
EventEmitter.prototype.once = function once(event, fn, context) {
  return addListener(this, event, fn, context, true);
};

/**
 * Remove the listeners of a given event.
 *
 * @param {(String|Symbol)} event The event name.
 * @param {Function} fn Only remove the listeners that match this function.
 * @param {*} context Only remove the listeners that have this context.
 * @param {Boolean} once Only remove one-time listeners.
 * @returns {EventEmitter} `this`.
 * @public
 */
EventEmitter.prototype.removeListener = function removeListener(event, fn, context, once) {
  var evt = prefix ? prefix + event : event;

  if (!this._events[evt]) return this;
  if (!fn) {
    clearEvent(this, evt);
    return this;
  }

  var listeners = this._events[evt];

  if (listeners.fn) {
    if (
      listeners.fn === fn &&
      (!once || listeners.once) &&
      (!context || listeners.context === context)
    ) {
      clearEvent(this, evt);
    }
  } else {
    for (var i = 0, events = [], length = listeners.length; i < length; i++) {
      if (
        listeners[i].fn !== fn ||
        (once && !listeners[i].once) ||
        (context && listeners[i].context !== context)
      ) {
        events.push(listeners[i]);
      }
    }

    //
    // Reset the array, or remove it completely if we have no more listeners.
    //
    if (events.length) this._events[evt] = events.length === 1 ? events[0] : events;
    else clearEvent(this, evt);
  }

  return this;
};

/**
 * Remove all listeners, or those of the specified event.
 *
 * @param {(String|Symbol)} [event] The event name.
 * @returns {EventEmitter} `this`.
 * @public
 */
EventEmitter.prototype.removeAllListeners = function removeAllListeners(event) {
  var evt;

  if (event) {
    evt = prefix ? prefix + event : event;
    if (this._events[evt]) clearEvent(this, evt);
  } else {
    this._events = new Events();
    this._eventsCount = 0;
  }

  return this;
};

//
// Alias methods names because people roll like that.
//
EventEmitter.prototype.off = EventEmitter.prototype.removeListener;
EventEmitter.prototype.addListener = EventEmitter.prototype.on;

//
// Expose the prefix.
//
EventEmitter.prefixed = prefix;

//
// Allow `EventEmitter` to be imported as module namespace.
//
EventEmitter.EventEmitter = EventEmitter;

//
// Expose the module.
//
if (true) {
  module.exports = EventEmitter;
}


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/services/geocoding.js":
/*!***************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/services/geocoding.js ***!
  \***************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var xtend = __webpack_require__(/*! xtend */ "./node_modules/xtend/immutable.js");
var v = __webpack_require__(/*! ./service-helpers/validator */ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/validator.js");
var pick = __webpack_require__(/*! ./service-helpers/pick */ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/pick.js");
var stringifyBooleans = __webpack_require__(/*! ./service-helpers/stringify-booleans */ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/stringify-booleans.js");
var createServiceFactory = __webpack_require__(/*! ./service-helpers/create-service-factory */ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/create-service-factory.js");

/**
 * Geocoding API service.
 *
 * Learn more about this service and its responses in
 * [the HTTP service documentation](https://docs.mapbox.com/api/search/#geocoding).
 */
var Geocoding = {};

var featureTypes = [
  'country',
  'region',
  'postcode',
  'district',
  'place',
  'locality',
  'neighborhood',
  'address',
  'poi',
  'poi.landmark'
];

/**
 * Search for a place.
 *
 * See the [public documentation](https://docs.mapbox.com/api/search/#forward-geocoding).
 *
 * @param {Object} config
 * @param {string} config.query - A place name.
 * @param {'mapbox.places'|'mapbox.places-permanent'} [config.mode="mapbox.places"] - Either `mapbox.places` for ephemeral geocoding, or `mapbox.places-permanent` for storing results and batch geocoding.
 * @param {Array<string>} [config.countries] - Limits results to the specified countries.
 *   Each item in the array should be an [ISO 3166 alpha 2 country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2).
 * @param {Coordinates} [config.proximity] - Bias local results based on a provided location.
 * @param {Array<'country'|'region'|'postcode'|'district'|'place'|'locality'|'neighborhood'|'address'|'poi'|'poi.landmark'>} [config.types] - Filter results by feature types.
 * @param {boolean} [config.autocomplete=true] - Return autocomplete results or not.
 * @param {BoundingBox} [config.bbox] - Limit results to a bounding box.
 * @param {number} [config.limit=5] - Limit the number of results returned.
 * @param {Array<string>} [config.language] - Specify the language to use for response text and, for forward geocoding, query result weighting.
 *  Options are [IETF language tags](https://en.wikipedia.org/wiki/IETF_language_tag) comprised of a mandatory
 *  [ISO 639-1 language code](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) and optionally one or more IETF subtags for country or script.
 * @param {boolean} [config.routing=false] - Specify whether to request additional metadata about the recommended navigation destination. Only applicable for address features.
 * @return {MapiRequest}
 *
 * @example
 * geocodingClient.forwardGeocode({
 *   query: 'Paris, France',
 *   limit: 2
 * })
 *   .send()
 *   .then(response => {
 *     const match = response.body;
 *   });
 *
 * @example
 * // geocoding with proximity
 * geocodingClient.forwardGeocode({
 *   query: 'Paris, France',
 *   proximity: [-95.4431142, 33.6875431]
 * })
 *   .send()
 *   .then(response => {
 *     const match = response.body;
 *   });
 *
 * // geocoding with countries
 * geocodingClient.forwardGeocode({
 *   query: 'Paris, France',
 *   countries: ['fr']
 * })
 *   .send()
 *   .then(response => {
 *     const match = response.body;
 *   });
 *
 * // geocoding with bounding box
 * geocodingClient.forwardGeocode({
 *   query: 'Paris, France',
 *   bbox: [2.14, 48.72, 2.55, 48.96]
 * })
 *   .send()
 *   .then(response => {
 *     const match = response.body;
 *   });
 */
Geocoding.forwardGeocode = function(config) {
  v.assertShape({
    query: v.required(v.string),
    mode: v.oneOf('mapbox.places', 'mapbox.places-permanent'),
    countries: v.arrayOf(v.string),
    proximity: v.coordinates,
    types: v.arrayOf(v.oneOf(featureTypes)),
    autocomplete: v.boolean,
    bbox: v.arrayOf(v.number),
    limit: v.number,
    language: v.arrayOf(v.string),
    routing: v.boolean
  })(config);

  config.mode = config.mode || 'mapbox.places';

  var query = stringifyBooleans(
    xtend(
      { country: config.countries },
      pick(config, [
        'proximity',
        'types',
        'autocomplete',
        'bbox',
        'limit',
        'language',
        'routing'
      ])
    )
  );

  return this.client.createRequest({
    method: 'GET',
    path: '/geocoding/v5/:mode/:query.json',
    params: pick(config, ['mode', 'query']),
    query: query
  });
};

/**
 * Search for places near coordinates.
 *
 * See the [public documentation](https://docs.mapbox.com/api/search/#reverse-geocoding).
 *
 * @param {Object} config
 * @param {Coordinates} config.query - Coordinates at which features will be searched.
 * @param {'mapbox.places'|'mapbox.places-permanent'} [config.mode="mapbox.places"] - Either `mapbox.places` for ephemeral geocoding, or `mapbox.places-permanent` for storing results and batch geocoding.
 * @param {Array<string>} [config.countries] - Limits results to the specified countries.
 *   Each item in the array should be an [ISO 3166 alpha 2 country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2).
 * @param {Array<'country'|'region'|'postcode'|'district'|'place'|'locality'|'neighborhood'|'address'|'poi'|'poi.landmark'>} [config.types] - Filter results by feature types.
 * @param {BoundingBox} [config.bbox] - Limit results to a bounding box.
 * @param {number} [config.limit=1] - Limit the number of results returned. If using this option, you must provide a single item for `types`.
 * @param {Array<string>} [config.language] - Specify the language to use for response text and, for forward geocoding, query result weighting.
 *  Options are [IETF language tags](https://en.wikipedia.org/wiki/IETF_language_tag) comprised of a mandatory
 *  [ISO 639-1 language code](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) and optionally one or more IETF subtags for country or script.
 * @param {'distance'|'score'} [config.reverseMode='distance'] - Set the factors that are used to sort nearby results.
 * @param {boolean} [config.routing=false] - Specify whether to request additional metadata about the recommended navigation destination. Only applicable for address features.
 * @return {MapiRequest}
 *
 * @example
 * geocodingClient.reverseGeocode({
 *   query: [-95.4431142, 33.6875431]
 * })
 *   .send()
 *   .then(response => {
 *     // GeoJSON document with geocoding matches
 *     const match = response.body;
 *   });
 */
Geocoding.reverseGeocode = function(config) {
  v.assertShape({
    query: v.required(v.coordinates),
    mode: v.oneOf('mapbox.places', 'mapbox.places-permanent'),
    countries: v.arrayOf(v.string),
    types: v.arrayOf(v.oneOf(featureTypes)),
    bbox: v.arrayOf(v.number),
    limit: v.number,
    language: v.arrayOf(v.string),
    reverseMode: v.oneOf('distance', 'score'),
    routing: v.boolean
  })(config);

  config.mode = config.mode || 'mapbox.places';

  var query = stringifyBooleans(
    xtend(
      { country: config.countries },
      pick(config, [
        'country',
        'types',
        'bbox',
        'limit',
        'language',
        'reverseMode',
        'routing'
      ])
    )
  );

  return this.client.createRequest({
    method: 'GET',
    path: '/geocoding/v5/:mode/:query.json',
    params: pick(config, ['mode', 'query']),
    query: query
  });
};

module.exports = createServiceFactory(Geocoding);


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/create-service-factory.js":
/*!********************************************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/services/service-helpers/create-service-factory.js ***!
  \********************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var MapiClient = __webpack_require__(/*! ../../lib/classes/mapi-client */ "./node_modules/@mapbox/mapbox-sdk/lib/classes/mapi-client.js");
// This will create the environment-appropriate client.
var createClient = __webpack_require__(/*! ../../lib/client */ "./node_modules/@mapbox/mapbox-sdk/lib/browser/browser-client.js");

function createServiceFactory(ServicePrototype) {
  return function(clientOrConfig) {
    var client;
    if (MapiClient.prototype.isPrototypeOf(clientOrConfig)) {
      client = clientOrConfig;
    } else {
      client = createClient(clientOrConfig);
    }
    var service = Object.create(ServicePrototype);
    service.client = client;
    return service;
  };
}

module.exports = createServiceFactory;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/object-map.js":
/*!********************************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/services/service-helpers/object-map.js ***!
  \********************************************************************************/
/***/ ((module) => {

"use strict";


function objectMap(obj, cb) {
  return Object.keys(obj).reduce(function(result, key) {
    result[key] = cb(key, obj[key]);
    return result;
  }, {});
}

module.exports = objectMap;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/pick.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/services/service-helpers/pick.js ***!
  \**************************************************************************/
/***/ ((module) => {

"use strict";


/**
 * Create a new object by picking properties off an existing object.
 * The second param can be overloaded as a callback for
 * more fine grained picking of properties.
 * @param {Object} source
 * @param {Array<string>|function(string, Object):boolean} keys
 * @returns {Object}
 */
function pick(source, keys) {
  var filter = function(key, val) {
    return keys.indexOf(key) !== -1 && val !== undefined;
  };

  if (typeof keys === 'function') {
    filter = keys;
  }

  return Object.keys(source)
    .filter(function(key) {
      return filter(key, source[key]);
    })
    .reduce(function(result, key) {
      result[key] = source[key];
      return result;
    }, {});
}

module.exports = pick;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/stringify-booleans.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/services/service-helpers/stringify-booleans.js ***!
  \****************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var objectMap = __webpack_require__(/*! ./object-map */ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/object-map.js");

/**
 * Stringify all the boolean values in an object, so true becomes "true".
 *
 * @param {Object} obj
 * @returns {Object}
 */
function stringifyBoolean(obj) {
  return objectMap(obj, function(_, value) {
    return typeof value === 'boolean' ? JSON.stringify(value) : value;
  });
}

module.exports = stringifyBoolean;


/***/ }),

/***/ "./node_modules/@mapbox/mapbox-sdk/services/service-helpers/validator.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@mapbox/mapbox-sdk/services/service-helpers/validator.js ***!
  \*******************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var xtend = __webpack_require__(/*! xtend */ "./node_modules/xtend/immutable.js");
var v = __webpack_require__(/*! @mapbox/fusspot */ "./node_modules/@mapbox/fusspot/lib/index.js");

function file(value) {
  // If we're in a browser so Blob is available, the file must be that.
  // In Node, however, it could be a filepath or a pipeable (Readable) stream.
  if (typeof window !== 'undefined') {
    if (value instanceof __webpack_require__.g.Blob || value instanceof __webpack_require__.g.ArrayBuffer) {
      return;
    }
    return 'Blob or ArrayBuffer';
  }
  if (typeof value === 'string' || value.pipe !== undefined) {
    return;
  }
  return 'Filename or Readable stream';
}

function assertShape(validatorObj, apiName) {
  return v.assert(v.strictShape(validatorObj), apiName);
}

function date(value) {
  var msg = 'date';
  if (typeof value === 'boolean') {
    return msg;
  }
  try {
    var date = new Date(value);
    if (date.getTime && isNaN(date.getTime())) {
      return msg;
    }
  } catch (e) {
    return msg;
  }
}

function coordinates(value) {
  return v.tuple(v.number, v.number)(value);
}

module.exports = xtend(v, {
  file: file,
  date: date,
  coordinates: coordinates,
  assertShape: assertShape
});


/***/ }),

/***/ "./node_modules/@mapbox/parse-mapbox-token/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@mapbox/parse-mapbox-token/index.js ***!
  \**********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var base64 = __webpack_require__(/*! base-64 */ "./node_modules/base-64/base64.js");

var tokenCache = {};

function parseToken(token) {
  if (tokenCache[token]) {
    return tokenCache[token];
  }

  var parts = token.split('.');
  var usage = parts[0];
  var rawPayload = parts[1];
  if (!rawPayload) {
    throw new Error('Invalid token');
  }

  var parsedPayload = parsePaylod(rawPayload);

  var result = {
    usage: usage,
    user: parsedPayload.u
  };
  if (has(parsedPayload, 'a')) result.authorization = parsedPayload.a;
  if (has(parsedPayload, 'exp')) result.expires = parsedPayload.exp * 1000;
  if (has(parsedPayload, 'iat')) result.created = parsedPayload.iat * 1000;
  if (has(parsedPayload, 'scopes')) result.scopes = parsedPayload.scopes;
  if (has(parsedPayload, 'client')) result.client = parsedPayload.client;
  if (has(parsedPayload, 'll')) result.lastLogin = parsedPayload.ll;
  if (has(parsedPayload, 'iu')) result.impersonator = parsedPayload.iu;

  tokenCache[token] = result;
  return result;
}

function parsePaylod(rawPayload) {
  try {
    return JSON.parse(base64.decode(rawPayload));
  } catch (parseError) {
    throw new Error('Invalid token');
  }
}

function has(obj, key) {
  return Object.prototype.hasOwnProperty.call(obj, key);
}

module.exports = parseToken;


/***/ }),

/***/ "./node_modules/base-64/base64.js":
/*!****************************************!*\
  !*** ./node_modules/base-64/base64.js ***!
  \****************************************/
/***/ (function(module, exports, __webpack_require__) {

/* module decorator */ module = __webpack_require__.nmd(module);
var __WEBPACK_AMD_DEFINE_RESULT__;/*! http://mths.be/base64 v0.1.0 by @mathias | MIT license */
;(function(root) {

	// Detect free variables `exports`.
	var freeExports =  true && exports;

	// Detect free variable `module`.
	var freeModule =  true && module &&
		module.exports == freeExports && module;

	// Detect free variable `global`, from Node.js or Browserified code, and use
	// it as `root`.
	var freeGlobal = typeof __webpack_require__.g == 'object' && __webpack_require__.g;
	if (freeGlobal.global === freeGlobal || freeGlobal.window === freeGlobal) {
		root = freeGlobal;
	}

	/*--------------------------------------------------------------------------*/

	var InvalidCharacterError = function(message) {
		this.message = message;
	};
	InvalidCharacterError.prototype = new Error;
	InvalidCharacterError.prototype.name = 'InvalidCharacterError';

	var error = function(message) {
		// Note: the error messages used throughout this file match those used by
		// the native `atob`/`btoa` implementation in Chromium.
		throw new InvalidCharacterError(message);
	};

	var TABLE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
	// http://whatwg.org/html/common-microsyntaxes.html#space-character
	var REGEX_SPACE_CHARACTERS = /[\t\n\f\r ]/g;

	// `decode` is designed to be fully compatible with `atob` as described in the
	// HTML Standard. http://whatwg.org/html/webappapis.html#dom-windowbase64-atob
	// The optimized base64-decoding algorithm used is based on @atk’s excellent
	// implementation. https://gist.github.com/atk/1020396
	var decode = function(input) {
		input = String(input)
			.replace(REGEX_SPACE_CHARACTERS, '');
		var length = input.length;
		if (length % 4 == 0) {
			input = input.replace(/==?$/, '');
			length = input.length;
		}
		if (
			length % 4 == 1 ||
			// http://whatwg.org/C#alphanumeric-ascii-characters
			/[^+a-zA-Z0-9/]/.test(input)
		) {
			error(
				'Invalid character: the string to be decoded is not correctly encoded.'
			);
		}
		var bitCounter = 0;
		var bitStorage;
		var buffer;
		var output = '';
		var position = -1;
		while (++position < length) {
			buffer = TABLE.indexOf(input.charAt(position));
			bitStorage = bitCounter % 4 ? bitStorage * 64 + buffer : buffer;
			// Unless this is the first of a group of 4 characters…
			if (bitCounter++ % 4) {
				// …convert the first 8 bits to a single ASCII character.
				output += String.fromCharCode(
					0xFF & bitStorage >> (-2 * bitCounter & 6)
				);
			}
		}
		return output;
	};

	// `encode` is designed to be fully compatible with `btoa` as described in the
	// HTML Standard: http://whatwg.org/html/webappapis.html#dom-windowbase64-btoa
	var encode = function(input) {
		input = String(input);
		if (/[^\0-\xFF]/.test(input)) {
			// Note: no need to special-case astral symbols here, as surrogates are
			// matched, and the input is supposed to only contain ASCII anyway.
			error(
				'The string to be encoded contains characters outside of the ' +
				'Latin1 range.'
			);
		}
		var padding = input.length % 3;
		var output = '';
		var position = -1;
		var a;
		var b;
		var c;
		var d;
		var buffer;
		// Make sure any padding is handled outside of the loop.
		var length = input.length - padding;

		while (++position < length) {
			// Read three bytes, i.e. 24 bits.
			a = input.charCodeAt(position) << 16;
			b = input.charCodeAt(++position) << 8;
			c = input.charCodeAt(++position);
			buffer = a + b + c;
			// Turn the 24 bits into four chunks of 6 bits each, and append the
			// matching character for each of them to the output.
			output += (
				TABLE.charAt(buffer >> 18 & 0x3F) +
				TABLE.charAt(buffer >> 12 & 0x3F) +
				TABLE.charAt(buffer >> 6 & 0x3F) +
				TABLE.charAt(buffer & 0x3F)
			);
		}

		if (padding == 2) {
			a = input.charCodeAt(position) << 8;
			b = input.charCodeAt(++position);
			buffer = a + b;
			output += (
				TABLE.charAt(buffer >> 10) +
				TABLE.charAt((buffer >> 4) & 0x3F) +
				TABLE.charAt((buffer << 2) & 0x3F) +
				'='
			);
		} else if (padding == 1) {
			buffer = input.charCodeAt(position);
			output += (
				TABLE.charAt(buffer >> 2) +
				TABLE.charAt((buffer << 4) & 0x3F) +
				'=='
			);
		}

		return output;
	};

	var base64 = {
		'encode': encode,
		'decode': decode,
		'version': '0.1.0'
	};

	// Some AMD build optimizers, like r.js, check for specific condition patterns
	// like the following:
	if (
		true
	) {
		!(__WEBPACK_AMD_DEFINE_RESULT__ = (function() {
			return base64;
		}).call(exports, __webpack_require__, exports, module),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	}	else { var key; }

}(this));


/***/ }),

/***/ "./node_modules/is-plain-obj/index.js":
/*!********************************************!*\
  !*** ./node_modules/is-plain-obj/index.js ***!
  \********************************************/
/***/ ((module) => {

"use strict";

var toString = Object.prototype.toString;

module.exports = function (x) {
	var prototype;
	return toString.call(x) === '[object Object]' && (prototype = Object.getPrototypeOf(x), prototype === null || prototype === Object.getPrototypeOf({}));
};


/***/ }),

/***/ "./node_modules/xtend/immutable.js":
/*!*****************************************!*\
  !*** ./node_modules/xtend/immutable.js ***!
  \*****************************************/
/***/ ((module) => {

module.exports = extend

var hasOwnProperty = Object.prototype.hasOwnProperty;

function extend() {
    var target = {}

    for (var i = 0; i < arguments.length; i++) {
        var source = arguments[i]

        for (var key in source) {
            if (hasOwnProperty.call(source, key)) {
                target[key] = source[key]
            }
        }
    }

    return target
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			id: moduleId,
/******/ 			loaded: false,
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/node module decorator */
/******/ 	(() => {
/******/ 		__webpack_require__.nmd = (module) => {
/******/ 			module.paths = [];
/******/ 			if (!module.children) module.children = [];
/******/ 			return module;
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
(() => {
/*!***********************************!*\
  !*** ./resources/js/geocoding.js ***!
  \***********************************/
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return; var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

var maxBox = __webpack_require__(/*! @mapbox/mapbox-sdk/services/geocoding */ "./node_modules/@mapbox/mapbox-sdk/services/geocoding.js");

var accessToken = 'pk.eyJ1Ijoic2FtdWVsbW95IiwiYSI6ImNrbWh0OGlmdDBhcjUyb3FrNHZrMzNmZzYifQ.AaPcDO7yug_8u9RtRZ349w';
var geocoding = maxBox({
  accessToken: accessToken
});

var geoLocateAddress = function geoLocateAddress(address) {
  return new Promise(function (resolve, reject) {
    geocoding.forwardGeocode({
      query: address,
      countries: ['pe'],
      language: ['es'],
      limit: 1
    }).send().then(function (response) {
      resolve(response.body);
    });
  });
};

var street = document.getElementById('street');
var city = document.getElementById('city'); // Address geo location event

street.addEventListener('keyup', function () {
  defer(geoLocateAddress(street.value).then(function (response) {
    resultsTemplate(response.features, '#street-results');
  }), 1500);
}); // City geo location event

city.addEventListener('keyup', function () {
  defer(geoLocateAddress(city.value).then(function (response) {
    resultsTemplate(response.features, '#city-results');
  }), 1500);
}); // Hide geo location results when leaving street

document.addEventListener('click', function (e) {
  if (!e.target.matches('div#street-results') || !e.target.matches('div#city-results')) {
    document.getElementById('street-results').classList.add('hidden');
    document.getElementById('city-results').classList.add('hidden');
  }
}); //Executes a callback after a given time has passed

function defer(fn, ms) {
  var timer = 0;
  return function () {
    clearTimeout(timer);

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    timer = setTimeout(fn.bind.apply(fn, [this].concat(args)), ms || 0);
  };
}

var resultsTemplate = function resultsTemplate(results, target) {
  var items = '<li class="suggestion py-3 px-3 flex border-gray-300">No se han encontrado resultados</li>';
  var item_selector = target.replace('#', '');

  if (results.length > 0) {
    items = '';

    for (var i = 0; i < results.length; i++) {
      var _results$i$geometry$c = _slicedToArray(results[i].geometry.coordinates, 2),
          longitude = _results$i$geometry$c[0],
          latitude = _results$i$geometry$c[1];

      var splitAddress = results[i].place_name.split(',');

      var _street = splitAddress.shift().trim();

      var country = splitAddress.pop().trim();

      var _city = splitAddress.join(', ').trim();

      items += "<li class=\"suggestion py-4 px-4 flex border-gray-300 cursor-pointer hover:bg-gray-100\">\n<i class=\"fas fa-map-marker-alt mr-2 \"></i>\n<div class=\"".concat(item_selector, "\" data-street=\"").concat(_street, "\" data-lat=\"").concat(latitude, "\" data-lon=\"").concat(longitude, "\"\ndata-city=\"").concat(_city, "\" data-country=\"").concat(country, "\">").concat(results[i].place_name, "</div>\n</li>");
    }
  }

  var list = "<ul class=\"mt-2 bg-white rounded border-gray-200 shadow-md\">".concat(items, "</ul>");
  document.querySelector(target).innerHTML = list;
  document.querySelector(target).classList.remove('hidden');
}; // Event listener for each geo location search result


var geo_results = document.querySelectorAll('.geo-coder-results');

for (var i = 0; i < geo_results.length; i++) {
  geo_results[i].addEventListener('click', function (e) {
    var clickedAddress = e.target;

    if (e.target && e.target.matches('div.street-results')) {
      //Get to the nearest input
      if (clickedAddress.dataset.street) {
        street.value = clickedAddress.dataset.street;
        document.getElementById('latitude').value = clickedAddress.dataset.lat;
        document.getElementById('longitude').value = clickedAddress.dataset.lon;
      } //Get to the nearest input


      if (clickedAddress.dataset.city) {
        city.value = clickedAddress.dataset.city;
      }
    }

    if (e.target && e.target.matches('div.city-results')) {
      //Get to the nearest input
      if (clickedAddress.dataset.city) {
        city.value = clickedAddress.dataset.street + ', ' + clickedAddress.dataset.city;
      }
    }

    clickedAddress.parentElement.parentElement.parentElement.classList.add('hidden');
  });
}
})();

/******/ })()
;