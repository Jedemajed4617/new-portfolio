import React, { useState, useEffect, useRef } from 'react';
import { Link } from "react-router-dom"; // Import Link from React Router
import './hamburger.css'; // Import the CSS file

const HamburgerMenu = () => {
    const [isOpen, setIsOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const menuRef = useRef(null); // Ref to access the menu container

    const toggleMenu = () => {
        setIsOpen(!isOpen);
        if (dropdownOpen) {
            setDropdownOpen(false); // Close dropdown when main menu is toggled
        }
    };

    const toggleDropdown = (e) => {
        e.preventDefault(); // Prevent the default anchor action
        setDropdownOpen(!dropdownOpen); // Toggle dropdown visibility
    };

    const handleClickOutside = (event) => {
        if (menuRef.current && !menuRef.current.contains(event.target)) {
            setIsOpen(false); // Close the menu if clicked outside
            setDropdownOpen(false); // Close dropdown if clicked outside
        }
    };

    useEffect(() => {
        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
            document.style.overflow = "hidden";
        };
    }, []);

    useEffect(() => {
        // Disable scrolling when menu is open
        document.body.style.overflow = isOpen ? 'hidden' : 'auto';
        return () => {
            document.body.style.overflow = 'auto'; // Ensure scrolling is re-enabled when the component is unmounted
        };
    }, [isOpen]);

    return (
        <div className="menu-container" ref={menuRef}>
            <div className="menu-icon" onClick={toggleMenu}>
                <span className={`menu-bar ${isOpen ? 'open' : ''}`}></span>
                <span className={`menu-bar ${isOpen ? 'open' : ''}`}></span>
                <span className={`menu-bar ${isOpen ? 'open' : ''}`}></span>
            </div>
            <nav className={`menu ${isOpen ? 'open' : ''}`}>
                <ul>
                    <li><Link to="/" onClick={toggleMenu}>Home</Link></li>
                    <li><Link to="/about" onClick={toggleMenu}>About</Link></li>
                    <li><Link to="/contact" onClick={toggleMenu}>Contact</Link></li>
                    <li className="dropdown">
                        <a href="#" onClick={toggleDropdown}>Projects &#9662;</a>
                        <ul className={`dropdown-content ${dropdownOpen ? 'open' : ''}`}>
                            <li><Link to="/school" onClick={toggleMenu}>School</Link></li>
                            <li><Link to="/selfmade" onClick={toggleMenu}>Selfmade</Link></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    );
};


export default HamburgerMenu;