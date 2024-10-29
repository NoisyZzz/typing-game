@extends('layouts.app')

@section('content')
<div class="container">
    <h1>- Modo Normal</h1>
    <h2>Nivel: <span id="level-display">1</span></h2>
    <p id="word-display">Presiona 'Empezar' para iniciar</p>
    <input type="text" id="input-field" class="form-control" disabled>
    <button id="start-game" class="btn btn-primary">Empezar</button>
    <div id="result"></div>

    <img src="{{ asset('images/Mecanografia.jpg') }}" alt="Imagen de ejemplo" width="500">
</div>

<script>
    // Palabras y tiempos de cada nivel
    const levels = {
        1: { words: ["gato", "sol", "pan"], time: 2 },
        2: { words: ["perro", "luz", "casa"], time: 3 },
        3: { words: ["libro", "mesa", "flor"], time: 3 },
        4: { words: ["elefante", "ratón", "nube"], time: 4 },
        5: { words: ["bicicleta", "montaña", "computadora"], time: 5 },
        6: { words: ["misterio", "teclado", "escritorio"], time: 6 },
        7: { words: ["universidad", "tecnología", "bicicletas"], time: 6 },
        8: { words: ["computadoras", "estadísticas", "experimento"], time: 7 },
        9: { words: ["matemáticas", "programación", "filosofía"], time: 8 },
        10: { words: ["transdisciplinario", "comunicaciones", "microbiología"], time: 9 },
        11: { words: ["El gato está en el tejado"], time: 10 },
        12: { words: ["La luna brilla en el cielo nocturno"], time: 12 },
        13: { words: ["Las montañas son altas y majestuosas"], time: 14 },
        14: { words: ["La computadora tiene una gran pantalla"], time: 15 },
        15: { words: ["Los estudiantes estudian programación avanzada"], time: 16 },
        16: { words: ["La ciencia es fundamental para el progreso humano"], time: 18 },
        17: { words: ["La universidad es un lugar de conocimiento y descubrimiento"], time: 20 },
        18: { words: ["Las tecnologías avanzadas transforman nuestra sociedad"], time: 22 },
        19: { words: ["La biología estudia los organismos vivos en detalle"], time: 24 },
        20: { words: ["El conocimiento científico impulsa el desarrollo tecnológico"], time: 26 },
        21: { words: ["El aprendizaje continuo es clave para el desarrollo personal."], time: 30 },
        22: { words: ["Las redes sociales han transformado la comunicación global."], time: 32 },
        23: { words: ["La inteligencia artificial está revolucionando múltiples industrias."], time: 34 },
        24: { words: ["La investigación científica requiere rigor y precisión."], time: 36 },
        25: { words: ["El trabajo en equipo potencia la creatividad y la innovación."], time: 38 }
    };

    let currentLevel = 1;
    let currentWord = "";
    let startTime, endTime;
    let timer;
    let bonusTimeActive = false; 
    let Extralevels = false;
    let levelCompletionTimes = []; 

    const levelDisplay = document.getElementById('level-display');
    const wordDisplay = document.getElementById('word-display');
    const inputField = document.getElementById('input-field');
    const startGameButton = document.getElementById('start-game');
    const resultDiv = document.getElementById('result');

    function startGame() {
        clearInterval(timer); 
        inputField.disabled = false;
        inputField.value = '';
        resultDiv.innerHTML = '';

        if (currentLevel === 10) {
            bonusTimeActive = true;
            resultDiv.innerHTML = `Felicidades has conseguido un comodín ahora tienes 5 segundos extra por los siguientes 5 niveles`;
        }

        let levelTime = levels[currentLevel].time;

        if (bonusTimeActive && currentLevel <= 15) {
            levelTime += 5;
        }

        currentWord = levels[currentLevel].words[Math.floor(Math.random() * levels[currentLevel].words.length)];
        wordDisplay.innerHTML = currentWord;
        inputField.focus();
        startTime = new Date().getTime();

        timer = setTimeout(() => {
            resultDiv.innerHTML = `¡Tiempo agotado! Vuelve a intentar el nivel ${currentLevel}`;
            resetLevel();
        }, levelTime * 1000); 
    }

    function checkTyping() {
        if (inputField.value === currentWord) {
            clearInterval(timer); 
            endTime = new Date().getTime();
            const timeTaken = (endTime - startTime) / 1000;

            
            levelCompletionTimes.push(timeTaken);

            
            const averageTime = levelCompletionTimes.reduce((a, b) => a + b, 0) / levelCompletionTimes.length;

            if (timeTaken <= levels[currentLevel].time) {
                resultDiv.innerHTML = `Nivel ${currentLevel} completado en ${timeTaken.toFixed(2)} segundos`;
                currentLevel++;

                
                if (currentLevel > 20 && !Extralevels && averageTime < (levels[10].time + levels[11].time + levels[12].time + levels[13].time + levels[15].time) / 5) {
                    Extralevels = true; 
                    resultDiv.innerHTML += `<br>¡Has habilitado los niveles extra!`;
                }

                if (currentLevel > 25) {
                    wordDisplay.innerHTML = "¡Felicidades! Has completado todos los niveles";
                    inputField.disabled = true;
                    startGameButton.disabled = true;
                } else {
                    inputField.disabled = true;
                    wordDisplay.innerHTML = `Presiona 'Empezar' para el siguiente nivel`;
                    levelDisplay.innerHTML = currentLevel;
                }
            } else {
                resultDiv.innerHTML = `¡Tiempo excedido! Vuelve a intentar el nivel ${currentLevel}`;
                resetLevel();
            }
        }
    }

    function resetLevel() {
        clearInterval(timer);
        inputField.value = '';
        inputField.disabled = true;
        wordDisplay.innerHTML = `Presiona 'Empezar' para intentar el nivel ${currentLevel} nuevamente`;
    }

    startGameButton.addEventListener('click', startGame);
    inputField.addEventListener('input', checkTyping);
</script>
@endsection
