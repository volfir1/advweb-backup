import React from 'react';
import '../../css/admin-header.css'

function header(){
return(
<section>
<section>
    <header className="header">
        <img src="../logos/baketogo.jpg" alt="Company Logo" className="logo" />
        <nav>
            <ul>
                <li><a href="/">Logout</a></li>
            </ul>
        </nav>
    </header>

    <aside className="sidebar">
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/services">Services</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </nav>
    </aside>
</section>

</section>
)
   
}
const container = document.getElementById('App');
export default header;