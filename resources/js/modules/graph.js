// Chart.defaults.font.family = 'Sen-Bold';
// Chart.defaults.plugins.legend = false;
// Chart.defaults.font.size = 24;
// Chart.defaults.color = 'red';
// Chart.defaults.global.defaultFontFamily = 'Sen-Bold';

if (document.getElementById('myChart')) {
    Chart.defaults.font.family = 'Sen-Bold';
    const data = {
        labels: [
            'Digitale Transformation',
            'Digitalisierte Produkte',
            'Digitalisierte Prozesse',
            'Digit. Mitarbeiter',
            'Digitale Kundenanbindung',
            'Digitale Lieferantenanbindung',
            'Digitalisierte Maschinen',
            'Digitale Daten',
        ],
        datasets: [{
            label: 'Reifegrad der Firma',
            lineTension: 0.1,
            // pointBorderWidth: 10,
            pointRadius: 4,
            data: [],
            fill: true,
            backgroundColor: 'rgba(82, 187, 181, 0.2)',
            borderColor: 'rgb(82, 187, 181)',
            pointBackgroundColor: 'rgb(82, 187, 181)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(82, 187, 181)'
        },
            // {
            //     label: 'My Second Dataset',
            //     data: [28, 48, 40, 19, 96, 27, 100],
            //     fill: true,
            //     backgroundColor: 'rgba(54, 162, 235, 0.2)',
            //     borderColor: 'rgb(54, 162, 235)',
            //     pointBackgroundColor: 'rgb(54, 162, 235)',
            //     pointBorderColor: '#fff',
            //     pointHoverBackgroundColor: '#fff',
            //     pointHoverBorderColor: 'rgb(54, 162, 235)'
            // }
        ]
    };

    const config = {
        type: 'radar',
        data: data,
        options: {
            scales: {
                r: {
                    beginAtZero: true,
                    min: 0,
                    stepSize: 1,
                    max: 4,
                    pointLabels: {
                        font: {
                            size: 12,
                        }
                    }
                }
            },
            plugins: {
                legend: false,
                title: {
                    display: true,
                    text: 'Reifegrad',
                    font: {
                        size: 24
                    }
                }
            },
            elements: {
                line: {
                    borderWidth: 2
                }
            },
        },
    };

    fetch('/results')
        .then(res => res.json())
        .then(results => {
            const resultsCount = results.length;
            let categories = [];

            results.forEach(result => {
                result.properties.forEach(property => {
                    const key = Object.keys(property)[0];
                    categories.push(key);
                });
            });

            let set = new Set(categories);
            let sums = [];

            Array.from(set).forEach((entry, i) => {
                sums[i] = 0;
                results.forEach(result => {
                    result.properties.forEach(property => {
                        const key = Object.keys(property)[0];
                        if (key === entry) {
                            sums[i] += property[key].mean;
                        }
                    });
                });
            });

            const means = sums.map(sum => sum / resultsCount);
            data.datasets[0].data = [...means];
            new Chart(
                document.getElementById('myChart'),
                config
            );
        })
}

if (document.getElementById('myDonut')) {
    Chart.defaults.font.family = 'Sen-Bold';
    const sent = document.getElementById('myDonut').getAttribute('data-js-sent');
    const notSent = document.getElementById('myDonut').getAttribute('data-js-not-sent') - sent;
    const data = {
        labels: [
            'ausgefüllt',
            'nicht ausgefüllt',
        ],
        datasets: [{
            data: [sent, notSent],
            backgroundColor: [
                'rgb(82, 187, 181)',
                'rgba(82, 187, 181, 0.2)'
            ],
            borderRadius: 10,
            borderWidth: 0,
            hoverOffset: 2,
            // circumference: 80,
            cutout: '80%',
            // radius: 90,
            // rotation: 25,
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Teilnahme',
                    font: {
                        size: 24
                    }
                }
            }
        }
    };

    new Chart(
        document.getElementById('myDonut'),
        config
    );


}
