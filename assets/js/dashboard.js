// Dashboard Charts and Animations
document.addEventListener('DOMContentLoaded', function() {
    // Añadir clases para animaciones
    const cards = document.querySelectorAll('.dashboard-card');
    cards.forEach((card, index) => {
        card.classList.add('fade-in');
        card.style.animationDelay = `${index * 0.1}s`;
    });

    const chartCards = document.querySelectorAll('.chart-card');
    chartCards.forEach((card, index) => {
        card.classList.add('fade-in');
        card.style.animationDelay = `${(cards.length + index) * 0.1}s`;
    });

    // Configuración de colores para los gráficos
    const chartColors = [
        {
            backgroundColor: 'rgba(78, 115, 223, 0.2)',
            borderColor: 'rgba(78, 115, 223, 1)',
        },
        {
            backgroundColor: 'rgba(28, 200, 138, 0.2)',
            borderColor: 'rgba(28, 200, 138, 1)',
        },
        {
            backgroundColor: 'rgba(246, 194, 62, 0.2)',
            borderColor: 'rgba(246, 194, 62, 1)',
        },
        {
            backgroundColor: 'rgba(231, 74, 59, 0.2)',
            borderColor: 'rgba(231, 74, 59, 1)',
        },
        {
            backgroundColor: 'rgba(54, 185, 204, 0.2)',
            borderColor: 'rgba(54, 185, 204, 1)',
        }
    ];

    // Configuración global para Chart.js
    if (typeof Chart !== 'undefined') {
        Chart.defaults.font.family = "'Nunito', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif";
        
        // Personalización de tooltips
        Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(255, 255, 255, 0.8)';
        Chart.defaults.plugins.tooltip.titleColor = '#4e73df';
        Chart.defaults.plugins.tooltip.bodyColor = '#858796';
        Chart.defaults.plugins.tooltip.borderColor = '#dddfeb';
        Chart.defaults.plugins.tooltip.borderWidth = 1;
        Chart.defaults.plugins.tooltip.displayColors = true;
        Chart.defaults.plugins.tooltip.mode = 'index';
        Chart.defaults.plugins.tooltip.intersect = false;

        // Plugin para animación al hacer hover sobre gráficos
        const hoverPlugin = {
            id: 'hoverEffect',
            beforeEvent(chart, args) {
                const event = args.event;
                if (event.type === 'mousemove') {
                    chart.canvas.style.cursor = 'pointer';
                }
                if (event.type === 'mouseout') {
                    chart.canvas.style.cursor = 'default';
                }
            }
        };

        // Mejorar la presentación de gráficos existentes
        enhanceCharts(chartColors, hoverPlugin);
    }

    // Función para mejorar los gráficos existentes
    function enhanceCharts(colors, plugin) {
        if (typeof ventasPorMesChart !== 'undefined') {
            enhanceLineChart(ventasPorMesChart, colors, plugin);
        }
        
        if (typeof ventasPorDiaChart !== 'undefined') {
            enhanceLineChart(ventasPorDiaChart, colors, plugin);
        }
        
        if (typeof productosMasVendidosChart !== 'undefined') {
            enhancePieChart(productosMasVendidosChart, colors, plugin);
        }
        
        if (typeof ventasPorCategoriaChart !== 'undefined') {
            enhancePieChart(ventasPorCategoriaChart, colors, plugin);
        }
    }

    // Mejora de gráficos de línea
    function enhanceLineChart(chart, colors, plugin) {
        if (!chart) return;
        
        // Añadir el plugin
        chart.options.plugins.hoverEffect = plugin;
        
        // Mejorar responsividad
        chart.options.responsive = true;
        chart.options.maintainAspectRatio = false;
        
        // Mejorar la presentación
        chart.options.plugins.legend.display = true;
        chart.options.plugins.legend.position = 'top';
        
        // Añadir animación al hover para los elementos
        chart.data.datasets.forEach((dataset, i) => {
            dataset.backgroundColor = colors[i % colors.length].backgroundColor;
            dataset.borderColor = colors[i % colors.length].borderColor;
            dataset.pointBackgroundColor = colors[i % colors.length].borderColor;
            dataset.pointBorderColor = '#fff';
            dataset.pointHoverRadius = 6;
            dataset.pointHoverBackgroundColor = colors[i % colors.length].borderColor;
            dataset.pointHoverBorderColor = '#fff';
            dataset.pointHoverBorderWidth = 2;
            dataset.tension = 0.3; // Curva suave para las líneas
        });
        
        chart.update();
    }

    // Mejora de gráficos de pie
    function enhancePieChart(chart, colors, plugin) {
        if (!chart) return;
        
        // Añadir el plugin
        chart.options.plugins.hoverEffect = plugin;
        
        // Mejorar responsividad
        chart.options.responsive = true;
        chart.options.maintainAspectRatio = false;
        
        // Mejorar la presentación
        chart.options.plugins.legend.display = true;
        chart.options.plugins.legend.position = 'right';
        
        // Mejorar animación al hover para los elementos
        const backgroundColors = colors.map(color => color.backgroundColor);
        const borderColors = colors.map(color => color.borderColor);
        
        chart.data.datasets.forEach(dataset => {
            const colorCount = dataset.data.length;
            const bgColors = [];
            const bdColors = [];
            
            for (let i = 0; i < colorCount; i++) {
                bgColors.push(backgroundColors[i % backgroundColors.length]);
                bdColors.push(borderColors[i % borderColors.length]);
            }
            
            dataset.backgroundColor = bgColors;
            dataset.borderColor = bdColors;
            dataset.borderWidth = 1;
            dataset.hoverOffset = 10;
        });
        
        chart.update();
    }

    // Añadir listener para redimensionar los gráficos cuando cambia el tamaño de la ventana
    window.addEventListener('resize', function() {
        if (typeof ventasPorMesChart !== 'undefined') ventasPorMesChart.resize();
        if (typeof ventasPorDiaChart !== 'undefined') ventasPorDiaChart.resize();
        if (typeof productosMasVendidosChart !== 'undefined') productosMasVendidosChart.resize();
        if (typeof ventasPorCategoriaChart !== 'undefined') ventasPorCategoriaChart.resize();
    });
}); 