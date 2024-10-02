import React, { useState, useEffect, useRef } from 'react';
import './school.css';

function School() {
    const [popupVisible, setPopupVisible] = useState(false);
    const [selectedProject, setSelectedProject] = useState(null);
    const [selectedTags, setSelectedTags] = useState([]);
    const [showFilters, setShowFilters] = useState(false);
    const dropdownRef = useRef(null); // Create a ref for the dropdown

    const projects = [
        { title: 'Netflix', link: 'https://tgsoftware.services/netflix', image: 'https://static.vecteezy.com/system/resources/previews/022/101/069/original/netflix-logo-transparent-free-png.png', description: "Remade the Netflix homepage login / register...", tags: "HTML, CSS" },
        { title: 'Website Grandpa', link: 'https://tgsoftware.services/carpediemchezmargreet', image: 'https://scontent-ams4-1.xx.fbcdn.net/v/t39.30808-6/451957143_3799346643638113_5450896627723457261_n.jpg?stp=cp6_dst-jpg&_nc_cat=103&ccb=1-7&_nc_sid=833d8c&_nc_ohc=SkkZi7CcskIQ7kNvgH89QlZ&_nc_ht=scontent-ams4-1.xx&oh=00_AYCGOPVJh17dzXlgBGb7tIQO1UUSbo9j5YhR3OVL4VH4CQ&oe=66F79D46', description: "This website I made for my grandparents...", tags: "HTML, CSS, JS" },
        { title: 'Simple Geometry Dash', link: 'https://tgsoftware.services/game', image: 'https://www1.minijuegosgratis.com/v3/games/thumbnails/213070_1.jpg', description: "This is a basic version of Geometry Dash...", tags: "HTML, CSS, JS" },
        { title: 'FlavorFlow', link: 'https://tgsoftware.services/flavorflow', image: 'https://cdn.pixabay.com/photo/2016/05/31/10/52/not-yet-1426593_640.png', description: "This is a project to learn PHP and JS integration...", tags: "PHP, CSS, JS" },
        { title: 'Storm Services', link: 'https://tgsoftware.services/storm', image: 'https://i.ytimg.com/vi/asTesU-2t3k/maxresdefault.jpg', description: "First website for a client using PHP...", tags: "PHP, CSS, JS" },
    ];

    const tags = ["HTML", "CSS", "JS", "PHP"];

    const openPopup = (project) => {
        setSelectedProject(project);
        setPopupVisible(true);
    };

    const closePopup = () => {
        setPopupVisible(false);
        setSelectedProject(null);
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

    const handleClickOutside = (event) => {
        if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
            setShowFilters(false); // Close the dropdown if clicking outside
        }
    };

    useEffect(() => {
        // Add event listener for clicks outside
        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            // Cleanup the event listener
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

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