import React, { useState } from 'react';
import '../../css/admin-header.css';

function Header() {
  const handleLogout = () => {
    window.location.href = '/logout'; // Directly change the window location
  };

  // Mock user data
  const user = {
    name: "John Doe",
    profilePic: "https://via.placeholder.com/50" // Replace with actual profile picture URL
  };

  const [dropdownVisible, setDropdownVisible] = useState(false);

  const toggleDropdown = () => {
    setDropdownVisible(!dropdownVisible);
  };

  return (
    <section>
      <header className="header">
        <div className="header-content">
          <img src="../logos/baketogo.jpg" alt="Company Logo" className="logo" />
          <div className="profile-section" onClick={toggleDropdown}>
            <img src={user.profilePic} alt="Profile" className="profile-pic" />
            <span className="welcome-message">Welcome, {user.name}</span>
            {dropdownVisible && (
              <ul className="profile-dropdown">
                <li><a onClick={handleLogout}>Logout</a></li>
                <li><a href="/manage-profile">Manage Profile</a></li>
              </ul>
            )}
          </div>
        </div>
      </header>
    </section>
  );
}

export default Header;
