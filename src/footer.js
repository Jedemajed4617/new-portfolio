import "./footer.css";

function getCurrentYear() {
    return new Date().getFullYear();
}

function Footer() {
    return (
        <footer>
            <div>
                <b className="copy">Copyright © {getCurrentYear()} - Tygo Jedema</b>
            </div>
        </footer>
    );
}

export default Footer;