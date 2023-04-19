const question = document.getElementById("question");
const choices = Array.from(document.getElementsByClassName("choice-text"));
const questionCounterText = document.getElementById("questionCounter");
const scoreText = document.getElementById("score");


let currentQuestion = {};
let acceptingAnswers = false;
let score = 0;
let questionCounter = 0;
let availableQuestions = [];
let questions = [];


fetch("https://opentdb.com/api.php?amount=10&category=9&difficulty=easy&type=multiple")

 .then(res => {
    return res.json();
 })
 .then(loadedQuestions => {
    console.log(loadedQuestions.results);
    questions = loadedQuestions.results.map(loadedQuestions => {
        const formattedQuestion = {
            question: loadedQuestions.question
        };

        const answerChoices = [ ... loadedQuestions.incorrect_answers];
        formattedQuestion.answer = Math.floor(Math.random() * 10) + 1;
        answerChoices.splice(formattedQuestion.answer - 1, 0,
            loadedQuestions.correct_answer);

        answerChoices.forEach((choice, index) => {
            formattedQuestion["choice" + (index + 1)] = choice;
        })

        return formattedQuestion;
    });
    startGame();
 })
 .catch(err => {
    console.error(err);
 });
 
const SCORE_POINTS = 10;
const MAX_QUESTIONS = 10;

const startGame = () => {
    questionCounter = 0;
    score = 0;
    availableQuestions = [... questions];
    getNewQuestion();
}

const getNewQuestion = () => {

    if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
        localStorage.setItem("mostRecentScore", score);
        return window.location.assign("end.html");
    };

    questionCounter++;
    questionCounterText.innerHTML = `${questionCounter}/${MAX_QUESTIONS}`;

    const questionIndex = Math.floor(Math.random() * availableQuestions.length);
    currentQuestion = availableQuestions[questionIndex];
    question.innerHTML = currentQuestion.question;

    choices.forEach(choice => {
        const number = choice.dataset["number"];
        choice.innerHTML = currentQuestion["choice" + number];
    });

    availableQuestions.splice(questionIndex, 1);
    acceptingAnswers = true;


};
    choices.forEach(choice => {
    choice.addEventListener("click", e => {
        if (!acceptingAnswers) return;
    
        acceptingAnswers = false;
        const selectedChoice = e.target;
        const selectedAnswer = selectedChoice.dataset["number"];
        
     
        const classToApply = selectedAnswer == currentQuestion.answer ? "correct" : "incorrect";
        console.log(classToApply);
        

        if (classToApply == "correct") {
            incrementScore(SCORE_POINTS);
        };
           
        selectedChoice.parentElement.classList.add(classToApply);
         
         setTimeout(() => {
            selectedChoice.parentElement.classList.remove(classToApply);
            getNewQuestion();
         }, 1000);
    });
});

function incrementScore(num) {
    score += num;
    scoreText.innerText = score;
};

