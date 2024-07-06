import React from 'react';
import ReactDOM from 'react-dom/client';
import Header from './components/header'; // Adjust path as per your project structure
import Sidebar from './components/sidebar';
import '../css/app.css';


function App() {
    return (
        <div className="App">
            <Header />
            <div className="main-wrapper">
                <Sidebar />
                
            </div>
            
        </div>

        
    );
}

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('hello-react');
    if (container) {
        const root = ReactDOM.createRoot(container);
        root.render(<App />);
    } else {
        console.error('Element with id "hello-react" not found.');
    }
});

