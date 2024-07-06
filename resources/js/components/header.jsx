import React from 'react';
import '../../css/admin-header.css';

function Header() {
  const handleLogout = () => {
    window.location.href = '/logout'; // Directly change the window location
  };

  return (
    <section>
      <header className="header">
        <img src="../logos/baketogo.jpg" alt="Company Logo" className="logo" />
        <nav>
          <ul>
            <li><a onClick={handleLogout}>Logout</a></li>
          </ul>
        </nav>
      </header>
    </section>
  );
}

export default Header;
