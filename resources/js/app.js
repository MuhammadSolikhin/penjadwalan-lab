// Bootstrap 5
import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;               


// Jquery Global File
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// Script vanilla
import './script';

// Powergrid (Datatables)
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';

// Chart JS
import Chart from 'chart.js/auto';
window.Chart = Chart;