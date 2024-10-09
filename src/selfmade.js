import React, { useState, useRef } from 'react';
import './school.css';

function Selfmade() {
    const [popupVisible, setPopupVisible] = useState(false);
    const [selectedProject, setSelectedProject] = useState(null);
    const [selectedTags, setSelectedTags] = useState([]);
    const [showFilters, setShowFilters] = useState(false);
    const dropdownRef = useRef(null); // Create a ref for the dropdown

    const projects = [
        { 
            title: 'Netflix', 
            link: 'https://tgsoftware.services/netflix', 
            image: 'https://static.vecteezy.com/system/resources/previews/022/101/069/original/netflix-logo-transparent-free-png.png', 
            description: "Remade the Netflix homepage login / register screen. It closely mirrors the actual interface design and responsiveness to learn more about layout and styling.", 
            tags: "HTML, CSS" 
        },
        { 
            title: 'Website Grandpa', 
            link: 'https://tgsoftware.services/carpediemchezmargreet', 
            image: 'https://img.lamontagne.fr/YWk1tsoHfdd2PH_I6uaykPbkFuxmqsVmOx5Cmjba88Q/fit/657/438/sm/0/bG9jYWw6Ly8vMDAvMDAvMDEvMDgvODAvMjAwMDAwMTA4ODAxMA.jpg', 
            description: "This website I made for my grandparents showcases their bed and breakfast business, offering a clean and simple UI with easy navigation and a responsive layout.", 
            tags: "HTML, CSS, JS" 
        },
        { 
            title: 'Simple Geometry Dash', 
            link: 'https://tgsoftware.services/game', 
            image: 'https://www1.minijuegosgratis.com/v3/games/thumbnails/213070_1.jpg', 
            description: "This is a basic version of Geometry Dash where you control a square that jumps over obstacles, learning how to manage user input and object collision in the browser.", 
            tags: "HTML, CSS, JS" 
        },
        { 
            title: 'FlavorFlow', 
            link: 'https://tgsoftware.services/flavorflow', 
            image: 'https://cdn.pixabay.com/photo/2016/05/31/10/52/not-yet-1426593_640.png', 
            description: "This project was developed to learn more about integrating PHP with JS. It includes dynamic content generation and form handling, with a focus on user interaction.", 
            tags: "PHP, HTML, CSS, JS" 
        },
        { 
            title: 'Storm Services', 
            link: 'https://tgsoftware.services/storm', 
            image: 'https://i.ytimg.com/vi/asTesU-2t3k/maxresdefault.jpg', 
            description: "First website for a client using PHP to create a dynamic web presence for a storm repair service company. It features contact forms and service details.", 
            tags: "PHP, HTML, CSS, JS" 
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

export default Selfmade;
