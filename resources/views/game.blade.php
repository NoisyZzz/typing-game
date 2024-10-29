@extends('layouts.app')

@section('content')
<div class="container">
    <p>En este modo escribe frases y pon aprueba tu velocidad con el teclado.</p>
</div>


<div class="container">
    <h1>- Modo Libre</h1>
    <p id="word-display">Escribe esta frase</p>
    <input type="text" id="input-field" class="form-control pulse">
    <button id="start-game" class="btn btn-primary">Empezar</button>

    <div id="result"></div>

    <script>
        let startTime;
        let endTime;
        const wordDisplay = document.getElementById('word-display');
        const inputField = document.getElementById('input-field');
        const resultDiv = document.getElementById('result');
        const startGameButton = document.getElementById('start-game');
        const words = [
            'Hola mundo', 'Aprender es divertido', 'Desarrolla rapido',
             'Anita lava la tina','El zorro rápido salta sobre el perro perezoso','Ayer Juan comió pizza y helado en el parque',
                'Los pingüinos nadan rápido en el océano helado','¿Cómo podrías hacer que un gato juegue con un perro?',
                'Mi teléfono móvil vibró cuando llegó el mensaje de texto.','Las águilas vuelan alto sobre las montañas nevadas.',
                'Una pequeña rana verde saltó sobre la gran roca gris.',"El teclado QWERTY es perfecto para escribir rápido.",
                "¿Sabías que el sol es una estrella gigante en el espacio?","El científico creó una nueva fórmula en su laboratorio.",
                "Cada mañana tomo café y leo el periódico digital.","Los trenes viajan rápidamente por las ciudades modernas.",
                "Hoy cociné arroz con pollo y una ensalada fresca.","Es importante practicar mecanografía todos los días.",
                "La familia disfrutó del picnic junto al río cristalino.","El gato negro trepó al árbol buscando una golondrina.",
                "Me gusta caminar al atardecer por la playa desierta.","El viento soplaba fuerte mientras los barcos navegaban.",
                "Para lograr grandes cosas, hay que trabajar duro siempre.","Las llaves están sobre la mesa, junto al reloj de oro.",
                "El avión despegó justo cuando el sol se ocultaba.","Las estrellas brillaban en el cielo claro de la noche."  
            ];

        startGameButton.addEventListener('click', startGame);

        function startGame() {
            inputField.value = '';
            resultDiv.innerHTML = '';
            wordDisplay.innerHTML = words[Math.floor(Math.random() * words.length)];
            startTime = new Date().getTime();
        }

        inputField.addEventListener('input', checkTyping);

        function checkTyping() {
            if (inputField.value === wordDisplay.innerHTML) {
                endTime = new Date().getTime();
                const timeTaken = (endTime - startTime) / 1000;
                resultDiv.innerHTML = `Has tomado ${timeTaken} segundos`;

                // Enviar puntaje al servidor
                saveScore(timeTaken);
            }
        }

        function saveScore(score) {
            fetch('{{ route('save.score') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ score: score })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>

<img src="{{ asset('images/Mecanografia.jpg') }}" alt="Imagen de ejemplo" width="500">

</div>
@endsection