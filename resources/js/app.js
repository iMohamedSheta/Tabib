import './bootstrap';
import flatpickr from "flatpickr";
import 'flatpickr/dist/flatpickr.min.css';
import { Arabic } from 'flatpickr/dist/l10n/ar.js';
import sort from '@alpinejs/sort'
import persist from '@alpinejs/persist'

Alpine.plugin(sort, persist);
flatpickr.localize(Arabic);  // Apply Arabic locale globally