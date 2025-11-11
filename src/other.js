import React, { useState, useRef } from 'react';
import './school.css';

function Other() {
	const [popupVisible, setPopupVisible] = useState(false);
	const [selectedProject, setSelectedProject] = useState(null);
	const [selectedTags, setSelectedTags] = useState([]);
	const [showFilters, setShowFilters] = useState(false);
	const dropdownRef = useRef(null); 

	const projects = [
		{ 
			title: 'NoLimitsInHair.', 
			link: 'https://test.nolimitsinhair.nl', 
			image: 'https://test.nolimitsinhair.nl/images/favicon/android-chrome-192x192.png', 
			description: "This is a website redesign i did under the supervision of Velisoft. The redesign of thsi website meant strip all of the files, work out new ideas and deliver this to them within a week.",
			tags: "HTML, CSS, JS, PHP, CI4",
		},
		{ 
			title: 'Final Fix Solutions.', 
			link: 'https://fix-solutions.com', 
			image: 'http://final-fix-solutions.velisoft.com/img/favicon.ico', 
			description: "This project i made from the ground up whilst working for Velisoft. This project needed to be somewhat the same as the nolimitsinhair before that website went for a redesign.",
			tags: "HTML, CSS, JS, PHP, CI4",
		},
		{ 
			title: 'Verbobouw B.V.', 
			link: 'https://verbobouw.nl', 
			image: 'https://www.verbobouw.nl/images/website/verbo_logo.png', 
			description: "This is an work project where I redid a website for velisoft. the old website looked very rough so i gave it a update. It is a website for a construction company that showcases their projects and services with a modern design.",
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

export default Other;
