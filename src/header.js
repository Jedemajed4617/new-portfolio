import "./header.css";
import "./about.css";
import "./skills.css";
import './hamburger';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faFaceLaugh } from "@fortawesome/free-regular-svg-icons";
import { faBookmark } from "@fortawesome/free-regular-svg-icons";
import { Link } from "react-router-dom"; // Import Link from React Router
import HamburgerMenu from "./hamburger";

function Header() {
  return (
    <header>
      <div className="imgcon">
        <FontAwesomeIcon className="fontawesomehead" icon={faFaceLaugh} />
        <div class="hamburgertje">
            <HamburgerMenu />
        </div>
      </div>
      <nav>
        <ul className="nav-list">
          <li className="pc"><Link to="/">Home</Link></li>
          <li className="phone"><Link to="/"><FontAwesomeIcon class="icon" icon={faBookmark} /></Link></li>
          <li><Link to="about">About Me</Link></li>
          <li><Link to="skills">Skills</Link></li>
          <li className="dropdown">
            <p>Projects &#9662;</p>
            <ul className="dropdown-content">
              <li><Link to="school">School</Link></li>
              <li><Link to="selfmade">Selfmade</Link></li>
            </ul>
          </li>
        </ul>
      </nav>
      <div className="buttoncon">
        <button><Link to="contact">Contact Me</Link></button>
      </div>
    </header>
  );
}

export default Header;