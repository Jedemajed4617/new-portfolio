import React, { useState, useRef } from 'react';
import './school.css';

function School() {
    const [popupVisible, setPopupVisible] = useState(false);
    const [selectedProject, setSelectedProject] = useState(null);
    const [selectedTags, setSelectedTags] = useState([]);
    const [showFilters, setShowFilters] = useState(false);
    const dropdownRef = useRef(null); // Create a ref for the dropdown

    const projects = [
        {
            title: 'Spatify (spotify clone)',
            link: 'https://tgsoftware.services/spatify',
            image: 'https://play-lh.googleusercontent.com/cShys-AmJ93dB0SV8kE6Fl5eSaf4-qMMZdwEDKI5VEmKAXfzOqbiaeAsqqrEBCTdIEs=w240-h480-rw',
            description: "This is a website a made for a school assignment. This website has it's own small library of songs that you can access. This was to train my PHP skills in sorting, searching and adding songs with a small custom CMS system.",
            tags: "PHP, HTML, CSS, JS",
        },
        {
            title: 'Daily Paper Clone',
            link: 'https://tgsoftware.services/dailypaper',
            image: 'https://www.asphaltgold.com/cdn/shop/files/ca802008830dc007677dcccde8cf41e179b52d66_2322035_Daily_Paper_Ezar_Zip_Hoodie_Black_os_3_768x768.jpg?v=1700042914',
            description: "This was an assignment for school I made with PHP. This is a full scale daily paper clone with working CMS, login, dispute system, review system and much more. Had so much fun creating this project because it enhanced my capability to write PHP.",
            tags: "PHP, HTML, CSS, JS",
        },
        {
            title: 'Tulpreizen',
            link: 'https://tgsoftware.services/tulpreizen',
            image: 'https://www.whiteflowerfarm.com/mas_assets/cache/image/9/4/e/b/38123.Jpg',
            description: "This was a small website for school that shows off a bit of SCSS skills I used for it. Nothing much to it other than nice!",
            tags: "HTML, SCSS, CSS",
        },
        {
            title: 'Font Showcase',
            link: 'https://tgsoftware.services/font-showcase',
            image: 'https://img.freepik.com/free-vector/creative-halloween-alphabet-design_23-2147932875.jpg?size=338&ext=jpg&ga=GA1.1.1413502914.1696809600&semt=ais',
            description: "This was a website created for previewing different font styles with JS. Anything you type into the bar will show it in the font listed.",
            tags: "HTML, CSS, JS",
        },
        {
            title: 'NVVN Website',
            link: 'https://tgsoftware.services/nvvn',
            image: 'https://nvvn.nl/wp-content/uploads/2021/06/NVVN-favicon.png',
            description: "This is a website made for the official NVVN. We needed to show what we had learned the previous years and just make a website for them.",
            tags: "PHP, HTML, CSS, JS",
        },
        {
            title: 'Qr Code',
            link: 'https://tgsoftware.services/qrcode',
            image: 'https://media.istockphoto.com/id/1347277567/vector/qr-code-sample-for-smartphone-scanning-on-white-background.jpg?s=612x612&w=0&k=20&c=PYhWHZ7bMECGZ1fZzi_-is0rp4ZQ7abxbdH_fm8SP7Q=',
            description: "This was a really fun project. This website I made could generate QR codes after you had taken a picture with any device on the website and if you had scanned the QR code you were redirected to a different page to collect your photo.",
            tags: "PHP, HTML, CSS, JS",
        },
        {
            title: 'Rabbit (Reddit clone)',
            link: 'https://tgsoftware.services/socialmedia',
            image: 'https://styles.redditmedia.com/t5_5s5qbl/styles/communityIcon_tqrzte0yaa3c1.png',
            description: "This was a small assignment for school creating the infinite scroller like Instagram, Reddit or Twitter. The content is drawn from an API and loaded in infinitely.",
            tags: "HTML, CSS, JS",
        },
    ];
    

    const tags = ["HTML", "CSS", "JS", "PHP"];

    const openPopup = (project) => {
        setSelectedProject(project);
        setPopupVisible(true);
    };

    const closePopup = () => {
        const popupContainer = document.querySelector('.grower2');
        if (popupContainer) {
            // Add the closing class to trigger the collapse animation
            popupContainer.classList.add('closing');
    
            // Wait for the animation to finish before actually closing the popup
            setTimeout(() => {
                setPopupVisible(false);
                setSelectedProject(null);
            }, 800); // Match the timeout with the animation duration (800ms)
        }
    };

    const handleTagChange = (tag) => {
        setSelectedTags(prevTags =>
            prevTags.includes(tag)
                ? prevTags.filter(t => t !== tag)
                : [...prevTags, tag]
        );
    };

    const filteredProjects = selectedTags.length === 0
    ? projects
    : projects.filter(project => 
        selectedTags.every(tag => project.tags.includes(tag))
    );

    return (
        <section className="school">
            <div className="school__filters" ref={dropdownRef}>
                <button className="dropdown-filtertoggle" onClick={() => setShowFilters(prev => !prev)}>
                    Filter by tags &#9662;
                </button>
                {showFilters && (
                    <div className="dropdown-filters">
                        {tags.map(tag => (
                            <label key={tag} className="filters">
                                <input
                                    type="checkbox"
                                    checked={selectedTags.includes(tag)}
                                    onChange={() => handleTagChange(tag)}
                                />
                                {tag}
                            </label>
                        ))}
                    </div>
                )}
            </div>

            <div className="school__divcardcontainer">
                {filteredProjects.map((project, index) => (
                    <div
                        key={index}
                        className="school__card"
                        style={{ animationDelay: `${index * 0.1}s` }}
                    >
                        <div className='school__cardimgcontainer'>
                            <img className="school__cardImage" src={project.image} alt={`Project ${index + 1}`} />
                        </div>
                        <div className="school__cardContent">
                            <h2 className="school__cardTitle">{project.title}</h2>
                            <p className="school__cardTags">tags: <b>{project.tags}</b></p>
                            <button className="school__cardButton" onClick={() => openPopup(project)}>
                                Learn more
                            </button>
                        </div>
                    </div>
                ))}
            </div>

            {popupVisible && selectedProject && (
                <div className="popup">
                    <div className="popupContainer grower2"> 
                        <div className="selectedImgContainer trans2">
                            <img className="popup__cardImage" src={selectedProject.image} alt={`Project ${selectedProject.index + 1}`} /> 
                        </div>
                        <div className="popup__content trans2">
                            <div className="textContainer">
                                <h2>{selectedProject.title}</h2>
                                <p>{selectedProject.description}</p>
                            </div>
                            <p className="school__cardTags">tags: <b>{selectedProject.tags}</b></p>
                            <div className="buttonscontainer">
                                <a className="school__cardButton" href={selectedProject.link} target="_blank" rel="noopener noreferrer">
                                    Go to Project
                                </a>
                                <button className="school__cardButton" onClick={closePopup}>Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </section>
    );
}

export default School;