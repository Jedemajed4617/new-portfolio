import React, { useState, useMemo, useEffect } from 'react';
import './home.css';
import './school.css';
import './cv.css';

function Home() {
    const [animationComplete, setAnimationComplete] = useState(false);
    const [displayText, setDisplayText] = useState('Fullstack Developer');
    const words = useMemo(() => ['Fullstack Developer', 'Web Developer', 'Back-end Developer'], []); 
    const [index, setIndex] = useState(0);
    const [isDeleting, setIsDeleting] = useState(false);
    const [showCursor, setShowCursor] = useState(true);
    const [popupVisible, setPopupVisible] = useState(false);
    const [selectedProject, setSelectedProject] = useState(null);

    useEffect(() => {
        const grower = document.querySelector('.grower');
        grower.addEventListener('animationend', () => {
            setAnimationComplete(true);
        });

        return () => grower.removeEventListener('animationend', () => {
            setAnimationComplete(true);
        });
    }, []);

    useEffect(() => {
        if (animationComplete) {
            const interval = setInterval(() => {
                setDisplayText(prev => {
                    if (!isDeleting) {
                        return prev.substring(0, prev.length - 1);
                    } else {
                        const nextWord = words[(index + 1) % words.length];
                        if (prev.length < nextWord.length) {
                            return nextWord.substring(0, prev.length + 1);
                        } else {
                            setIndex((index + 1) % words.length);
                            setIsDeleting(false);
                            return nextWord;
                        }
                    }
                });

                if (displayText === '') {
                    setIsDeleting(true);
                } else if (isDeleting && displayText === words[index]) {
                    setIsDeleting(false);
                }
            }, isDeleting ? 75 : 150);

            return () => clearInterval(interval);
        }
    }, [animationComplete, displayText, index, isDeleting, words]);

    useEffect(() => {
        const cursorInterval = setInterval(() => {
            setShowCursor(prev => !prev);
        }, 500);

        return () => clearInterval(cursorInterval);
    }, []);
    
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
            title: 'Self-made JS Image Library', 
            link: 'https://tgsoftware.services/jsimagelibrary', 
            image: '/img/JS.webp', 
            description: "This is a self-made JavaScript image library that allows you to create a gallery with images and videos. It includes features like lightbox, gallery mode, and more, showcasing my skills in JavaScript and DOM manipulation.",
            tags: "HTML, CSS, JS, PHP, CI4",
        },
        { 
            title: 'Flavorflow V2 - CI4', 
            link: 'https://velisoft.tgsoftware.services', 
            image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwg4WsbGgRcIft8CyVdsfw2iWuFIdkFfqcOA&s', 
            description: "This is an internship project where I created a website for myself. It is a website meant to simulate the same as Thuisbezorgd and to learn about using a framework called CodeIgniter 4.",
            tags: "CI4, HTML, CSS, JS, PHP",
            github: "https://github.com/Jedemajed4617/Flavorflow-v2-CI4",
        }
    ];

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

    return (
        <section className="homeContent" style={{ backgroundColor: '#1E1E1E' }}>
            <div className="maincontainer">
                <div className="container">
                    <div className="grower">
                        {animationComplete && (
                            <div id="nameText" className="trans">
                                <h1 className="eerste">My name is,</h1>
                                <div className="tranq">
                                    <h1 className="tweede">Tygo Jedema</h1>
                                    <h1 className="derde">I am a </h1>
                                </div>
                                <h1 className="vierde">
                                    {displayText}
                                    {showCursor && <span className="cursor-line"></span>} {/* Line instead of cursor */}
                                </h1>
                            </div>
                        )}
                    </div>
                </div>
            </div>
            <section className="school">
                <div className="maincontainer">
                    <div className="cv__content">
                        <h2 className="cv__section-title" style={{ textAlign: 'center !important', color: 'white' }}>Uitgelichte Projecten: </h2>
                    </div>
                    <div className="school__divcardcontainer">
                        {projects.map((project, index) => (
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
                                        <a className="school__cardButton" href="/projects/other" rel="noopener noreferrer">
                                            More projects
                                        </a>
                                        <button className="school__cardButton close" onClick={closePopup}>Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </section>
        </section>
    );
}

export default Home;