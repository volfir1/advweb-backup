import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import Header from './components/Header'; // Ensure correct casing and path
import Sidebar from './components/Sidebar'; // Ensure correct casing and path
import '../css/app.css'; // Ensure correct path to app.css
import axios from 'axios';

function App() {
    const [user, setUser] = useState(null);
    const [role, setRole] = useState(null);

    useEffect(() => {
        const fetchUserProfile = async () => {
            try {
                const response = await axios.get('/user/profile');
                setUser(response.data);
                setRole(response.data.role);
            } catch (error) {
                console.error('Error fetching user profile:', error);
            }
        };

        fetchUserProfile();
    }, []);

    if (!user) {
        return <div>Loading...</div>; // Or a loading spinner
    }

    return (
        <div className="App">
            <Header user={user} />
            <div className="main-wrapper">
                {role === 'admin' && <Sidebar />} {/* Only show Sidebar if role is 'admin' */}
                <div className="content">
                    <div className="welcome-message">
                        {role === 'admin' ? (
                            <div>
                               
                            </div>
                        ) : (
                            <div>
                                <h1>Welcome Customer, {user.name}</h1>
                                <button onClick={() => window.location.href = '/logout'} className="logout-button">Logout</button>
                            </div>
                        )}
                    </div>
                    {/* Content managed by Blade */}
                </div>
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
