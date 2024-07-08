import React, { useState } from 'react';
import PropTypes from 'prop-types';
import '../../css/admin-header.css';

function Header({ user }) {
  const handleLogout = () => {
    window.location.href = '/logout'; // Directly change the window location
  };

  const [dropdownVisible, setDropdownVisible] = useState(false);

  const toggleDropdown = () => {
    setDropdownVisible(!dropdownVisible);
  };

  // Determine the welcome message based on user role
  const getWelcomeMessage = () => {
    if (user.role === 'admin') {
      return `Welcome Admin, ${user.name}`;
    } else if (user.role === 'customer') {
      return `Welcome Customer, ${user.name}`;
    } else {
      return `Welcome, ${user.name}`;
    }
  };

  return (
    <section>
      <header className="header">
        <div className="header-content">
          <img src="../logos/baketogo.jpg" alt="Company Logo" className="logo" />
          <div className="profile-section" onClick={toggleDropdown} role="button" aria-haspopup="true" aria-expanded={dropdownVisible}>
            <img src={user.profilePic || 'https://via.placeholder.com/50'} alt="Profile" className="profile-pic" />
            <span className="welcome-message">{getWelcomeMessage()}</span>
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

Header.propTypes = {
  user: PropTypes.shape({
    name: PropTypes.string.isRequired,
    profilePic: PropTypes.string,
    role: PropTypes.string.isRequired,
  }).isRequired,
};

export default Header;
