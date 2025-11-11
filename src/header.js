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
      <div className="header">
        <div className="imgcon">
          <a href="/">
            <FontAwesomeIcon className="fontawesomehead" icon={faFaceLaugh} />
          </a>
          <div class="hamburgertje">
              <HamburgerMenu />
          </div>
        </div>
        <nav>
          <ul className="nav-list">
            <li className="pc"><Link to="/">Home</Link></li>
            <li className="phone"><Link to="/"><FontAwesomeIcon class="icon" icon={faBookmark} /></Link></li>
            <li><Link to="about">About</Link></li>
            <li><Link to="skills">Skills</Link></li>
            <li><Link to="cv">Curiculum Vitae</Link></li>
            <li className="dropdown">
              <p>Projects &#9662;</p>
              <ul className="dropdown-content">
                <li><Link to="projects/school">School</Link></li>
                <li><Link to="projects/selfmade">Hobby</Link></li>
                <li><Link to="projects/other">Other</Link></li>
              </ul>
            </li>
          </ul>
        </nav>
        <div className="buttoncon">
          <Link to="contact"><button>Contact Me</button></Link>
        </div>
      </div>
    </header>
  );
}

export default Header;