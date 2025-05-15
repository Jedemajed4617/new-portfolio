import "./footer.css";

function getCurrentYear() {
    return new Date().getFullYear();
}

function Footer() {
    return (
        <footer>
            <div className="maincontainer">
                <div>
                    <b className="copy">Copyright © {getCurrentYear()} - Tygo Jedema</b>
                </div>
            </div>
        </footer>
    );
}

export default Footer;