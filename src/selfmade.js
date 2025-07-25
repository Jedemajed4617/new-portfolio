import React, { useState, useRef } from 'react';
import './school.css';

function Selfmade() {
    const [popupVisible, setPopupVisible] = useState(false);
    const [selectedProject, setSelectedProject] = useState(null);
    const [selectedTags, setSelectedTags] = useState([]);
    const [showFilters, setShowFilters] = useState(false);
    const dropdownRef = useRef(null); 

    const projects = [
        { 
            title: 'Netflix', 
            link: 'https://tgsoftware.services/netflix', 
            image: 'https://static.vecteezy.com/system/resources/previews/022/101/069/original/netflix-logo-transparent-free-png.png', 
            description: "Remade the Netflix homepage login / register screen. It closely mirrors the actual interface design and responsiveness to learn more about layout and styling.", 
            tags: "HTML, CSS", 
            github: "https://github.com/Jedemajed4617/Notflix",
        },
        { 
            title: 'New portfolio', 
            link: 'https://tgsoftware.services/portfolio', 
            image: 'https://tgsoftware.services/portfolio/img/memyselfandi.png', 
            description: "Made a new portfolio website in html, css and js, without using internet to test my basic knowledge about coding", 
            tags: "HTML, CSS", 
            github: "",
        },
        { 
            title: 'Self-made JS Image Library', 
            link: 'https://tgsoftware.services/jsimagelibrary', 
            image: '/img/JS.webp', 
            description: "This is a self-made JavaScript image library that allows you to create a gallery with images and videos. It includes features like lightbox, gallery mode, and more, showcasing my skills in JavaScript and DOM manipulation.",
            tags: "HTML, CSS, JS, PHP, CI4",
        },
        { 
            title: 'Simple Geometry Dash', 
            link: 'https://tgsoftware.services/game', 
            image: 'https://www1.minijuegosgratis.com/v3/games/thumbnails/213070_1.jpg', 
            description: "This is a basic version of Geometry Dash where you control a square that jumps over obstacles, learning how to manage user input and object collision in the browser.", 
            tags: "HTML, CSS, JS",
            github: "https://github.com/Jedemajed4617/simple-geo-dash", 
        },
        { 
            title: 'FlavorFlow V1', 
            link: 'https://tgsoftware.services/flavorflow', 
            image: 'https://cdn.pixabay.com/photo/2016/05/31/10/52/not-yet-1426593_640.png', 
            description: "This project was developed to learn more about integrating PHP with JS. It includes dynamic content generation and form handling, with a focus on user interaction.", 
            tags: "PHP, HTML, CSS, JS", 
            github: "https://github.com/Jedemajed4617/FlavorFlow.app",
        },
        { 
            title: 'Verbobouw B.V.', 
            link: 'https://verbobouw.nl', 
            image: 'https://www.verbobouw.nl/images/website/verbo_logo.png', 
            description: "This is an work project where I redone a website for velisoft. the old website looked very rough so i gave it a update. It is a website for a construction company that showcases their projects and services with a modern design.",
            tags: "HTML, CSS, JS, PHP, CI4",
        },
        { 
            title: 'Flavorflow V2 - CI4', 
            link: 'https://velisoft.tgsoftware.services', 
            image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwg4WsbGgRcIft8CyVdsfw2iWuFIdkFfqcOA&s', 
            description: "This is an internship project where I created a website for myself. It is a website meant to simulate the same as Thuisbezorgd and to learn about using a framework called CodeIgniter 4.",
            tags: "CI4, HTML, CSS, JS, PHP",
            github: "https://github.com/Jedemajed4617/Flavorflow-v2-CI4",
        },
        { 
            title: 'Zwaan West-friesland', 
            link: 'https://zwaanwf.nl', 
            image: 'https://www.zwaanwf.nl/images/logo-zwaan2.png', 
            description: "This is an work project where I redone a website for velisoft. the old website looked very rough and was made with wordpress so i gave it a update. It is a website for a construction company that showcases their projects and services with a new modern design.",
            tags: "HTML, CSS, JS, PHP, CI4",
        },
        { 
            title: 'Bruinsma Timmerwerken', 
            link: 'https://bruinsmatimmerwerken.nl', 
            image: 'https://bruinsmatimmerwerken.nl/images/bruinsma-logo.jpg', 
            description: "This is an work project where I redone a website for velisoft. the old website was non-existent anymore so i made a new website for them. It is a website for a woodworking company that showcases their projects and services with a complete redesign.",
            tags: "HTML, CSS, JS, PHP, CI4",
        },
    ];

    const tags = ["HTML", "CSS", "JS", "PHP", "ReactJS", "Typescript", "Tailwindcss", "CI4", "Laravel"];

    const openPopup = (project) => {
        setSelectedProject(project);
        setPopupVisible(true);
    };

    const closePopup = () => {
        const popupContainer = document.querySelector('.grower2');
        if (popupContainer) {
            popupContainer.classList.add('closing');

            setTimeout(() => {
                setPopupVisible(false);
                setSelectedProject(null);
            }, 800);
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
            <div className="maincontainer">
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
                                        Project
                                    </a>
                                    <a
                                        className="school__cardButton"
                                        href={selectedProject.github}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        style={{ display: selectedProject.github ? 'inline-block' : 'none' }}
                                    >
                                        Github
                                    </a>
                                    <button className="school__cardButton close" onClick={closePopup}>Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </section>
    );
}

export default Selfmade;
