document.addEventListener("DOMContentLoaded", function () {
    let savingsData = [];

    function calculateBudget() {
        let income = parseFloat(document.getElementById("income").value) || 0;
        let rent = parseFloat(document.getElementById("rent").value) || 0;
        let food = parseFloat(document.getElementById("food").value) || 0;
        let transport = parseFloat(document.getElementById("transport").value) || 0;
        let groceries = parseFloat(document.getElementById("groceries").value) || 0;
        let other = parseFloat(document.getElementById("other").value) || 0;
        let healthInsurance = parseFloat(document.getElementById("healthInsurance").value) || 0;
        let carInsurance = parseFloat(document.getElementById("carInsurance").value) || 0;
        let homeInsurance = parseFloat(document.getElementById("homeInsurance").value) || 0;
        let vacation = parseFloat(document.getElementById("vacation").value) || 0;
        let taxes = parseFloat(document.getElementById("taxes").value) || 0;

        let totalMonthly = rent + food + transport + groceries + other;
        let totalAnnual = (healthInsurance + carInsurance + homeInsurance + vacation + taxes) / 12;
        let savings = income - (totalMonthly + totalAnnual);
        let yearlySavings = savings * 12;

        document.getElementById("totalMonthly").textContent = totalMonthly.toFixed(2);
        document.getElementById("totalAnnual").textContent = totalAnnual.toFixed(2);
        document.getElementById("savings").textContent = savings.toFixed(2);
        document.getElementById("yearlySavings").textContent = yearlySavings.toFixed(2);

        // Update savings data for graph
        savingsData = [];
        for (let i = 1; i <= 10; i++) { // Simulating 10 years
            savingsData.push(yearlySavings * i);
        }
    }

    function showSavingsGraph() {
        let ctx = document.getElementById("savingsChart").getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Year 1", "Year 2", "Year 3", "Year 4", "Year 5", "Year 6", "Year 7", "Year 8", "Year 9", "Year 10"],
                datasets: [{
                    label: "Savings Over the Years",
                    data: savingsData,
                    borderColor: "#35424a",
                    backgroundColor: "rgba(53, 66, 74, 0.2)",
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    document.getElementById("calculate-btn").addEventListener("click", calculateBudget);
    document.getElementById("show-graph-btn").addEventListener("click", showSavingsGraph);
});2