import './bootstrap';
import '../css/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import DeanDashboard from './Pages/Dean/Dashboard';

// Add this console.log for debugging
console.log('App.jsx is running');

const element = document.getElementById('app');
if (element) {
    // Add this console.log to verify the element is found
    console.log('Found app element, mounting React');
    createRoot(element).render(
        <React.StrictMode>
            <DeanDashboard />
        </React.StrictMode>
    );
}
