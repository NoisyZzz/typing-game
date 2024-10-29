@extends('layouts.app')

@section('content')
<div class="container">
    <h1>- Modo Aleatorio</h1>
    <p id="word-display"></p>
    <input type="text" id="input-field" class="form-control">
    <button id="start-game" class="btn btn-primary">Empezar</button>
    <div id="result"></div>

    <script>
       
        const wordList = 
        [
            "gato", "perro", "elefante", "ratón", "bicicleta", "computadora",
             "teclado", "montaña", "ciudad", "cielo","rápido","fútbol","programa",
             "desafío","electrónico","tecnología","desarrollador","interfaz",
             "monitor","teclado","procesador","javascript","navegador","aplicación",
             "depuración"
            
        ];
        let startTime, endTime;
        const wordDisplay = document.getElementById('word-display');
        const inputField = document.getElementById('input-field');
        const resultDiv = document.getElementById('result');
        const startGameButton = document.getElementById('start-game');

        
        function randomizeCapitalization(word) {
            return word.split('').map(char => Math.random() > 0.5 ? char.toUpperCase() : char.toLowerCase()).join('');
        }

        
        function generateRandomWords() {
            let numberOfWords = 5;  
            let randomWords = [];

            for (let i = 0; i < numberOfWords; i++) {
                
                let randomWord = wordList[Math.floor(Math.random() * wordList.length)];

                
                let randomizedWord = randomizeCapitalization(randomWord);

                randomWords.push(randomizedWord);
            }

            return randomWords.join(' ');
        }

        
        startGameButton.addEventListener('click', startGame);

        function startGame() {
            inputField.value = '';
            resultDiv.innerHTML = '';
            wordDisplay.innerHTML = generateRandomWords();
            startTime = new Date().getTime();
        }

        
        inputField.addEventListener('input', checkTyping);

        function checkTyping() {
            if (inputField.value === wordDisplay.innerHTML) {
                endTime = new Date().getTime();
                const timeTaken = (endTime - startTime) / 1000;
                resultDiv.innerHTML = `Has tomado ${timeTaken} segundos`;

               
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
