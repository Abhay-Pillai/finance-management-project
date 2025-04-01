document.getElementById("currency-link").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default anchor behavior
    document.getElementById("currency-converter").scrollIntoView({ behavior: "smooth" });
});

document.getElementById("finance-link").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default anchor behavior
    document.getElementById("finance-calculator").scrollIntoView({ behavior: "smooth" });
});
document.getElementById("calculator-link").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default anchor behavior
    document.getElementById("calculator-container").scrollIntoView({ behavior: "smooth" });
});
document.getElementById("graph-link").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default anchor behavior
    document.getElementById("location-tracking").scrollIntoView({ behavior: "smooth" });
});
document.getElementById("video-link").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default anchor behavior
    document.getElementById("video-link-section").scrollIntoView({ behavior: "smooth" });
});
document.getElementById('converter-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const amount = parseFloat(document.getElementById('amount').value);
    const fromCurrency = document.getElementById('from-currency').value;
    const toCurrency = document.getElementById('to-currency').value;

    // Updated conversion rates including INR
    const rates = {
        INR: { USD: 0.012, EUR: 0.011, GBP: 0.0095, JPY: 1.60, INR: 1 },
        USD: { INR: 83.25, EUR: 0.85, GBP: 0.75, JPY: 110, USD: 1 },
        EUR: { INR: 90.50, USD: 1.18, GBP: 0.88, JPY: 129, EUR: 1 },
        GBP: { INR: 105.20, USD: 1.33, EUR: 1.14, JPY: 146, GBP: 1 },
        JPY: { INR: 0.63, USD: 0.0091, EUR: 0.0078, GBP: 0.0068, JPY: 1 }
    };

    if (isNaN(amount) || amount <= 0) {
        document.getElementById('conversion-result').innerText = "Please enter a valid amount!";
        return;
    }

    if (fromCurrency === toCurrency) {
        document.getElementById('conversion-result').innerText = `Converted Amount: ${amount} ${toCurrency}`;
    } else {
        const convertedAmount = (amount * rates[fromCurrency][toCurrency]).toFixed(2);
        document.getElementById('conversion-result').innerText = `Converted Amount: ${convertedAmount} ${toCurrency}`;
    }
});

document.getElementById('calculator-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const principal = parseFloat(document.getElementById('principal').value);
    const rate = parseFloat(document.getElementById('rate').value) / 100;
    const time = parseFloat(document.getElementById('time').value);

    const interest = (principal * rate * time).toFixed(2);
    const totalAmount = (principal + parseFloat(interest)).toFixed(2);
    document.getElementById('calculation-result').innerText = `Interest: ${interest}, Total Amount: ${totalAmount}`;
});

//udget Calculator
document.getElementById("budget-form").onsubmit = function(event) {
    event.preventDefault();
    const income = parseFloat(document.getElementById("income").value);
    const expenses = parseFloat(document.getElementById("expenses").value);
    const budgetLeft = income - expenses;
    document.getElementById("budget-result").innerText = "Remaining Budget: " + budgetLeft;
}

// Tax Calculator
document.getElementById("tax-form").onsubmit = function(event) {
    event.preventDefault();
    const income = parseFloat(document.getElementById("income-tax").value);
    const taxRate = parseFloat(document.getElementById("tax-rate").value);
    const tax = (income * taxRate) / 100;
    document.getElementById("tax-result").innerText = "Tax: " + tax;
}

// Tax Deductions
document.getElementById("tax-deductions-form").onsubmit = function(event) {
    event.preventDefault();
    const deductions = parseFloat(document.getElementById("deductions").value);
    document.getElementById("tax-deductions-result").innerText = "Tax Deductions: " + deductions;
}

function calculateTax() {
    // Get the income value
    let income = parseFloat(document.getElementById('income').value);

    // Validate the income input
    if (isNaN(income) || income <= 0) {
        alert("Please enter a valid income.");
        return;
    }

    // Initialize total deductions to 0
    let totalDeductions = 0;

    // Fixed deductions based on checkbox selection
    if (document.getElementById('section80c').checked) {
        totalDeductions += 150000; // Section 80C
    }
    if (document.getElementById('section80d').checked) {
        totalDeductions += 25000; // Section 80D (Health Insurance)
    }
    if (document.getElementById('section80g').checked) {
        totalDeductions += 10000; // Section 80G (Donations)
    }
    if (document.getElementById('home-loan-interest').checked) {
        totalDeductions += 200000; // Home Loan Interest (Section 24(b))
    }

    // Calculate the taxable income after deductions
    let taxableIncome = income - totalDeductions;

    // Ensure taxable income doesn't go negative
    if (taxableIncome < 0) {
        taxableIncome = 0;
    }

    // Function to calculate tax based on Indian progressive tax regime (New Regime)
    function calculateIndianTax(income) {
        let tax = 0;

        // Apply the Indian progressive tax regime for the financial year 2023-24
        if (income <= 250000) {
            tax = 0; // No tax for income up to ₹2,50,000
        } else if (income <= 500000) {
            tax = (income - 250000) * 0.05; // 5% tax for income between ₹2,50,001 to ₹5,00,000
        } else if (income <= 1000000) {
            tax = (500000 - 250000) * 0.05 + (income - 500000) * 0.20; // 20% tax for income between ₹5,00,001 to ₹10,00,000
        } else {
            tax = (500000 - 250000) * 0.05 + (1000000 - 500000) * 0.20 + (income - 1000000) * 0.30; // 30% tax for income above ₹10,00,000
        }

        return tax;
    }

    // Calculate the tax using the Indian progressive tax system
    let tax = calculateIndianTax(taxableIncome);

    // Display the result
    document.getElementById('tax-result').innerHTML = `
        <h2>Tax Calculation Result:</h2>
        <p>Annual Income: ₹${income.toFixed(2)}</p>
        <p>Total Deductions: ₹${totalDeductions.toFixed(2)}</p>
        <p>Taxable Income: ₹${taxableIncome.toFixed(2)}</p>
        <p>Total Tax Payable (Indian Tax System): ₹${tax.toFixed(2)}</p>
    `;
}

function trackLocation() {
    // Check if the browser supports geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;  // Latitude of the user
            var lon = position.coords.longitude; // Longitude of the user
            
            // Display latitude and longitude
            document.getElementById("location").innerHTML =
                "Latitude: " + lat + "<br>Longitude: " + lon;

        }, function(error) {
            // Display error message if geolocation fails
            document.getElementById("location").innerHTML = "Error: " + error.message;
            document.getElementById("city").innerHTML = "";
            document.getElementById("timezone").innerHTML = "";
        });
    } else {
        // Display message if geolocation is not supported
        document.getElementById("location").innerHTML = "Geolocation is not supported by this browser.";
    }
}