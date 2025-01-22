import './bootstrap';
import flatpickr from "flatpickr";
import 'flatpickr/dist/flatpickr.min.css';
import { Arabic } from 'flatpickr/dist/l10n/ar.js';
import sort from '@alpinejs/sort'
Alpine.plugin(sort)
flatpickr.localize(Arabic);  // Apply Arabic locale globally