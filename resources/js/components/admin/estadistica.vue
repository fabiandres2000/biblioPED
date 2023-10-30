<template>
    <div class="app-content content" v-if="!loading">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row"></div>
            <div class="content-body">
                <div class="row match-height">
                    <div class="col-xl-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Historial de busquedas</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="products-sales" class="height-500">
                                        <div class="hello" ref="chartdiv"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Historial de busquedas <br> por mes</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="products-sales" class="height-500">
                                        <div class="hello" ref="chartdivmeses"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Porcentaje de busquedas por dia de semana</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="products-sales" class="height-500">
                                        <div class="hello" ref="chartdivpie"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Palabras mas buscadas</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="products-sales" class="height-500">
                                        <div class="hello" ref="chartdivpalabras"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import * as adminService from "../../services/admin";

am4core.useTheme(am4themes_animated);

export default {
    data() {
        return {
            datos: null,
            chart: null,
            chart2: null,
            chart3: null,
            chart4: null
        };
    },
    mounted() {
        this.obtenerdatos();
        document.title = 'Estadistica - BiblioPED';
    },
    methods: {
        async obtenerdatos() {
            this.loading = true;
            await adminService.estadisticaData().then(respuesta => {
                this.datos = respuesta.data;
                this.generarGrafico(this.datos.busquedas_agrupadas);
                this.generarGraficoDias(this.datos.data_por_dia);
                this.generarGraficoMeses(this.datos.data_por_dmes);
                this.generarGraficopalabras(this.datos.palabras_mas_buscadas);
            });
        },
        generarGrafico(data_grafica) {

            let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);

            chart.paddingRight = 20;

            let data = [];
            let visits = 10;

            data_grafica.forEach(element => {
                data.push({
                    date: element.fecha,
                    name: element._id,
                    value: element.cantidad,
                });
            });

            chart.data = data;

            let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;

            let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;

            let series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "value";

            series.tooltipText = "{valueY.value}";
            chart.cursor = new am4charts.XYCursor();

            let scrollbarX = new am4charts.XYChartScrollbar();
            scrollbarX.series.push(series);
            chart.scrollbarX = scrollbarX;

            this.chart = chart;

            this.loading = false;
        },
        generarGraficoDias(data_grafica) {

            let chart2 = am4core.create(this.$refs.chartdivpie, am4charts.PieChart);

            chart2.paddingRight = 50;

            chart2.data = [
                {
                    "country": "Lunes",
                    "litres": data_grafica[0]
                }, {
                    "country": "Martes",
                    "litres": data_grafica[1]
                }, {
                    "country": "Miércoles",
                    "litres": data_grafica[2]
                }, {
                    "country": "Jueves",
                    "litres": data_grafica[3]
                }, {
                    "country": "Viernes",
                    "litres": data_grafica[4]
                }, {
                    "country": "Sábado",
                    "litres": data_grafica[5]
                }, {
                    "country": "Domingo",
                    "litres": data_grafica[6]
                },
            ];

            var pieSeries = chart2.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "litres";
            pieSeries.dataFields.category = "country";

            this.chart2 = chart2;

            this.loading = false;
        },
        generarGraficoMeses(data_grafica) {
            let chart = am4core.create(this.$refs.chartdivmeses, am4charts.XYChart);

            chart.paddingRight = 20;

            let data = [];
 
            let i = 0;
            var meses_del_anio = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"]
            data_grafica.forEach(element => {
                data.push({
                    category: meses_del_anio[i],
                    value: element,
                });
                i++;
            });

            chart.data = data;

            let categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 10;

            let valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;

            let series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueX = "value";
            series.dataFields.categoryY = "category";

            series.columns.template.tooltipText = "{valueX.value}";
            chart.cursor = new am4charts.XYCursor();


            this.chart3 = chart;

            this.loading = false;
        },
        generarGraficopalabras(data_grafica) {

            data_grafica.sort(function(a, b) {
                return a.count - b.count;
            });

            let chart = am4core.create(this.$refs.chartdivpalabras, am4charts.XYChart);

            chart.paddingRight = 20;

            let data = [];
 
            data_grafica.forEach(element => {
                data.push({
                    category: element.key,
                    value: element.count,
                });
            });

            chart.data = data;

            let categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 10;

            let valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;

            let series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueX = "value";
            series.dataFields.categoryY = "category";
            series.columns.template.fill = am4core.color("#FF5733");

            series.columns.template.tooltipText = "{valueX.value}";
            chart.cursor = new am4charts.XYCursor();


            this.chart4 = chart;

            this.loading = false;
        },
        beforeDestroy() {
            if (this.chart) {
                this.chart.dispose();
            }
            if (this.chart2) {
                this.chart2.dispose();
            }
            if (this.chart3) {
                this.chart3.dispose();
            }
        },
    }
}   
</script>
<style>
.hello {
    width: 100%;
    height: 500px;
}
</style>
