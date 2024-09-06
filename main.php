<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLIPFUNDS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .tracker { max-width: 950px; margin: auto; }
        .result { margin-top: 20px; font-weight: bold; }
        .loading { font-style: italic; color: gray; }
        label { display: block; margin-top: 10px; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body>
    <div class="tracker">
        <h2>FLIPFUNDS</h2>
        <form id="trackerForm">
            <label for="currency">Kriptovaluta:</label>
            <select id="currency" name="currency" required onchange="startTracking()">
                <option value="bitcoin">Bitcoin (BTC)</option>
                <option value="ethereum">Ethereum (ETH)</option>
                <option value="litecoin">Litecoin (LTC)</option>
                <option value="ripple">Ripple (XRP)</option>
                <option value="solana">Solana (SOL)</option>
            </select><br><br>

            <label for="amount">Mennyiség, amivel rendelkezel:</label>
            <input type="number" step="0.01" id="amount" name="amount" value="1" required><br><br>

            <label for="targetCurrency">Érték ebben a valutában:</label>
            <select id="targetCurrency" name="targetCurrency" required>
                <option value="usd">Amerikai Dollár (USD)</option>
                <option value="eur">Euró (EUR)</option>
                <option value="huf">Magyar Forint (HUF)</option>
            </select><br><br>

            <label for="days">Történelmi adatok napjai:</label>
            <input type="number" id="days" name="days" value="30" required><br><br>

            <input type="button" value="Érték Nyomon Követése" onclick="startTracking()">
        </form>

     
        <label id="currentPriceLabel">Aktuális ár: </label>
      
        <div id="result" class="result"></div>
       
        <canvas id="myChart" width="600" height="400"></canvas>
    </div>

    <script>
        
        let myChart;

      
        function startTracking() {
            const currency = document.getElementById('currency').value.toLowerCase();
            const amount = parseFloat(document.getElementById('amount').value);
            const targetCurrency = document.getElementById('targetCurrency').value.toLowerCase();
            const days = parseInt(document.getElementById('days').value);

         
            document.getElementById('result').innerHTML = `<span class="loading">Aktuális ár lekérése...</span>`;
            document.getElementById('currentPriceLabel').innerHTML = `Aktuális ár: Betöltés...`;

          
            fetch(`https://api.coingecko.com/api/v3/simple/price?ids=${currency}&vs_currencies=${targetCurrency}`)
                .then(response => response.json())
                .then(data => {
                    if (data[currency] && data[currency][targetCurrency]) {
                        const rate = data[currency][targetCurrency];
                        const value = rate * amount;

                        
                        const formattedRate = rate.toLocaleString('hu');
                        const formattedValue = value.toLocaleString('hu', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                     
                        document.getElementById('currentPriceLabel').innerHTML = `
                            A(z) ${currency.toUpperCase()} aktuális ára ${targetCurrency.toUpperCase()}-ban: ${formattedRate} ${targetCurrency.toUpperCase()}
                        `;

                 
                        document.getElementById('result').innerHTML = `
                            A(z) <strong>${amount}</strong> ${currency.toUpperCase()} értéke: <strong>${formattedValue}</strong> ${targetCurrency.toUpperCase()}
                        `;
                    } else {
                        document.getElementById('result').innerHTML = "Hiba az árfolyam lekérésekor.";
                        document.getElementById('currentPriceLabel').innerHTML = "Hiba az aktuális ár lekérésekor.";
                    }
                })
                .catch(error => {
                    document.getElementById('result').innerHTML = "Hiba az adatok lekérésekor.";
                    document.getElementById('currentPriceLabel').innerHTML = "Hiba az aktuális ár lekérésekor.";
                });

           
            fetch(`https://api.coingecko.com/api/v3/coins/${currency}/market_chart?vs_currency=${targetCurrency}&days=${days}`)
                .then(response => response.json())
                .then(data => {
                 
                    const prices = data.prices.map(price => price[1]);  
                    const labels = data.prices.map(price => new Date(price[0]).toLocaleDateString());  

               
                    if (myChart) {
                        myChart.destroy();
                    }

                  
                    const ctx = document.getElementById('myChart').getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,  
                            datasets: [{
                                label: `${currency.toUpperCase()} árfolyama ${targetCurrency.toUpperCase()}-ban (az elmúlt ${days} napban)`,
                                data: prices, 
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                tension: 0.1
                            }]
                        },
                        options: {
                            scales: {
                                x: { 
                                    title: {
                                        display: true,
                                        text: 'Dátum'
                                    }
                                },
                                y: { 
                                    title: {
                                        display: true,
                                        text: `Ár (${targetCurrency.toUpperCase()})`
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Hiba a történelmi adatok lekérésekor:', error);
                });
        }

        
        window.onload = function() {
            startTracking();  
        };
    </script>
</body>
</html>
