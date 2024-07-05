import React from 'react';
import ReactDOM from 'react-dom';
import Header from './components/header'; // Adjust path as per your project structure
import '../css/app.css'; // Ensure your global CSS is imported

function App() {
    return (
        <div>
            <Header />
            {/* Other components or content */}
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
