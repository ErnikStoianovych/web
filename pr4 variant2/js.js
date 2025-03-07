
const num1Input = document.getElementById("num1");
const num2Input = document.getElementById("num2");
const resultDisplay = document.getElementById("result");
const historyList = document.getElementById("history");


function calculate(operation) {
    let num1 = parseFloat(num1Input.value);
    let num2 = parseFloat(num2Input.value);
    let result;

    if (isNaN(num1) || isNaN(num2)) {
        result = "Помилка! Введіть числа.";
    } else {
        switch (operation) {
            case '+': result = num1 + num2; break;
            case '-': result = num1 - num2; break;
            case '*': result = num1 * num2; break;
            case '/': 
                result = num2 !== 0 ? num1 / num2 : "Помилка! Ділення на 0"; 
                break;
            case '%': result = num1 % num2; break;
            case '^': result = Math.pow(num1, num2); break;
            default: result = "Невідома операція";
        }
    }

    displayResult(result);
    saveToHistory(`${num1} ${operation} ${num2} = ${result}`);
}


function calculateRoot() {
    let num = parseFloat(num1Input.value);
    if (isNaN(num) || num < 0) {
        displayResult("Помилка! Введіть число ≥ 0");
    } else {
        let result = Math.sqrt(num);
        displayResult(result);
        saveToHistory(`√${num} = ${result}`);
    }
}

function displayResult(result) {
    resultDisplay.textContent = result;
}


function saveToHistory(entry) {
    let history = JSON.parse(localStorage.getItem("calcHistory")) || [];
    history.unshift(entry);
    localStorage.setItem("calcHistory", JSON.stringify(history));
    updateHistory();
}

function updateHistory() {
    historyList.innerHTML = "";
    let history = JSON.parse(localStorage.getItem("calcHistory")) || [];

    history.forEach(entry => {
        let li = document.createElement("li");
        li.textContent = entry;
        historyList.appendChild(li);
    });
}

function clearHistory() {
    localStorage.removeItem("calcHistory");
    updateHistory();
}

document.addEventListener("DOMContentLoaded", updateHistory);