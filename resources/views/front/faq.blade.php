<x-front-layout>
    <div class="main-min-height p-5">
        <h1 class="text-center mb-5 font-extrabold text-xl">FAQ – {{ config('app.name') }}</h1>
        <div class="question mb-5">
            <p class="font-extrabold text-lg mb-5">1. Creo que los datos de un especialista no son correctos, ¿Cómo puedo corregirlos?</p>
            <div class="pl-5">
                <p>
                    Si has tenido una consulta con el especialista y te has dado cuenta de que hay datos que son erróneos,
                    puedes ponerte en contacto con nosotros a través del mail
                    <a class="text-blue-500 underline" href="mailto:soporte@psico-group.com">soporte@psico-group.com</a>
                    para que podamos ponernos
                    en contacto con el profesional, contrastar la información y corregir los datos.
                </p>
            </div>
        </div>
        <div class="question mb-5">
            <p class="font-extrabold text-lg mb-5">
                2. ¿Cómo funciona la consulta online?
            </p>
            <div class="pl-5">
                <p>Si el especialista hace consultas online saldrá en su perfil qué aplicación suele usar para sus consultas y una vez que hayan contactado y dependiendo de la aplicación, te enviará un link para el día de la consulta.</p>
            </div>
        </div>
        <div class="question mb-5">
            <p class="font-extrabold text-lg mb-5">
                3. ¿Cómo sé si el perfil del profesional que me interesa está verificado?
            </p>
            <div class="pl-5">
                <p>Todos los perfiles de los profesionales pasan por un estricto control, en el que no solamente verificamos la información que pone, sino que no se le da de alta hasta que no hayamos confirmado sus datos, su número de colegiado y si está habilitado para poder ejercer.</p>
            </div>
        </div>
        <div class="question mb-5">
            <p class="font-extrabold text-lg mb-5">
                4. No he recibido el enlace con el correo electrónico para verificar mi cuenta, ¿Qué hago?
            </p>
            <div class="pl-5">
                <p>Si no has recibido el correo electrónico en tu bandeja principal mira en la bandeja de correo no deseado, a veces que llegan ahí por equivocación. Si en caso no te ha llegado en ninguna de las dos bandejas y has esperado un tiempo prudencial, ponte en contacto con nosotros al mail
                    <a class="text-blue-500 cursor-pointer underline" href="mailto:soporte@psico-group.com">soporte@psico-group.com</a> para que te enviemos otro mail o te lo hagamos llegar de alguna otra manera.</p>
            </div>
        </div>
        <div class="question mb-5">
            <p class="font-extrabold text-lg mb-5">
                5. No quiero recibir notificaciones
            </p>
            <div class="pl-5">
                <p>Las notificaciones que recibirás por mail son las notificaciones de tus citas con tus especialistas, no te enviaremos ninguna otra notificación, si de todas maneras quieres dejar de recibir las notificaciones, ponte en contacto con nosotros a través del mail
                    <a class="text-blue-500 underline cursor-pointer" href="mailto:protecciondedatos@psico-group.com">protecciondedatos@psico-group.com</a>.</p>
            </div>
        </div>
        <div class="question mb-5">
            <p class="font-extrabold text-lg mb-5">
                6. ¿Cómo puedo eliminar mi cuenta?
            </p>
            <div class="pl-5">
                <p>Si no estás satisfecho con lo que ofrecemos, háznoslo saber a través de nuestro mail <a class="underline text-blue-500 cursor-pointer" href="mailto:hola@psico-group.com">hola@psico-group.com</a> y así nos puedes ayudar a mejorar. Si aún así quieres eliminar tu cuenta, lamentaremos mucho que te vayas; para eliminar tu cuenta deberás enviarnos un mail a
                    <a class="underline text-blue-500 cursor-pointer" href="mailto:soporte@psico-group.com">soporte@psico-group.com</a>.</p>
            </div>
        </div>
        <div class="question mb-5">
            <p class="font-extrabold text-lg mb-5">
                7. No puedo acceder a mi cuenta, ¿Cómo reestablezco la contraseña?
            </p>
            <div class="pl-5">
                <p>Si olvidaste tu contraseña o no puedes acceder a tu cuenta, haz clic en <a class="underline text-blue-500 cursor-pointer" class="text-blue-500 cursor-pointer underline" href="{{ route('password.request') }}">este enlace</a> y sigue los pasos que saldrán en tu pantalla.</p>
            </div>
        </div>
    </div>
</x-front-layout>
