import React, { useState } from 'react';
import PropTypes from 'prop-types';
import '../../css/admin-header.css';
import SearchRoundedIcon from '@mui/icons-material/SearchRounded';
import PersonRoundedIcon from '@mui/icons-material/PersonRounded'; // Importing manage profile icon
import ExitToAppRoundedIcon from '@mui/icons-material/ExitToAppRounded'; // Importing logout icon

function Header({ user }) {
  const handleLogout = () => {
    window.location.href = '/logout';
  };

  const [dropdownVisible, setDropdownVisible] = useState(false);

  const toggleDropdown = () => {
    setDropdownVisible(!dropdownVisible);
  };

  const getWelcomeMessage = () => {
    const role = user.role === 'admin' ? 'Admin' : user.role === 'customer' ? 'Customer' : '';
    return (
      <>
        Welcome {role}, <span className="welcome-name">{user.name}</span>
      </>
    );
  };

  return (
    <header className="header">
      <div className="header-content">
        <img src="../logos/baketogo.jpg" alt="Company Logo" className="logo" />
        <div className="search-bar">
          <input type="text" placeholder="Search..." className="search-input" />
          <SearchRoundedIcon className="search-icon" />
        </div>
        <div 
          className="profile-section" 
          onClick={toggleDropdown} 
          role="button" 
          aria-haspopup="true" 
          aria-expanded={dropdownVisible}
        >
          <img src={user.profilePic || 'https://via.placeholder.com/40'} alt="Profile" className="profile-pic" />
          <span className="welcome-message">{getWelcomeMessage()}</span>
          <ul className={`profile-dropdown ${dropdownVisible ? 'visible' : ''}`}>
            <li>
              <PersonRoundedIcon className="dropdown-icon" /> 
              <a href="/manage-profile">Manage Profile</a>
            </li>
            <li>
              <ExitToAppRoundedIcon className="dropdown-icon" /> 
              <a onClick={handleLogout}>Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </header>
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
