import "./about.css";
import React, { useState, useEffect } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faUser, faClipboard, faCompass, faNewspaper } from "@fortawesome/free-regular-svg-icons";

function About() {
    const geboortedatum = '2003-02-22'; // Gebruik het formaat YYYY-MM-DD
    
    // Functie om leeftijd te berekenen
    const berekenLeeftijd = (geboortedatum) => {
        const geboorteDatum = new Date(geboortedatum);
        const huidigeDatum = new Date();
        
        let leeftijd = huidigeDatum.getFullYear() - geboorteDatum.getFullYear();
        
        // Controleer of de verjaardag al is geweest dit jaar
        const huidigeJaarGeboorteDatum = new Date(
            huidigeDatum.getFullYear(),
            geboorteDatum.getMonth(),
            geboorteDatum.getDate()
        );
        
        if (huidigeDatum < huidigeJaarGeboorteDatum) {
            leeftijd--;
        }
        
        return leeftijd;
    };
    
    const [leeftijd, setLeeftijd] = useState(berekenLeeftijd(geboortedatum));
  
    useEffect(() => {
        setLeeftijd(berekenLeeftijd(geboortedatum));
    }, [geboortedatum]);
    return (
        <section className="about">
            <div className="maincontainer3">
                <div className="about__contentManagement">   
                    <li className="about__content about__delay--1">
                        <div className="about__contentImgContainer">
                            <FontAwesomeIcon className="about__contentIcon" icon={faNewspaper} />
                        </div>
                        <div className="about__contentTextArea">
                            <h1 className="about__contentTitle">Over mij:</h1>
                            <p className="about__contentInfo">
                                Mijn naam is Tygo. Ik ben {leeftijd} jaar oud en volg een opleiding tot full stack software developer. 
                                Mijn focus ligt op het ontwikkelen van webapplicaties en het continu verbeteren van mijn vaardigheden in verschillende programmeertalen en frameworks.
                            </p>
                        </div>
                    </li>
                </div>
                <div className="about__contentManagement1">   
                    <li className="about__content1 about__delay--2">
                        <div className="about__contentImgContainer">
                            <FontAwesomeIcon className="about__contentIcon" icon={faCompass} />
                        </div>
                        <div className="about__contentTextArea">
                            <h1 className="about__contentTitle">Toekomstvisie:</h1>
                            <p className="about__contentInfo">
                                Mijn doel is om me breed te ontwikkelen als developer en diepgaande kennis op te bouwen binnen softwareontwikkeling. 
                                Daarnaast spreekt de zakelijke kant van het vak mij aan. In de toekomst wil ik graag mijn eigen onderneming starten in de tech-sector.
                            </p>        
                        </div>
                    </li>
                </div>
                <div className="about__contentManagement">   
                    <li className="about__content about__delay--3">
                        <div className="about__contentImgContainer">
                            <FontAwesomeIcon className="about__contentIcon" icon={faClipboard} />
                        </div>
                        <div className="about__contentTextArea">
                            <h1 className="about__contentTitle">Focus & groei:</h1>
                            <p className="about__contentInfo">
                                Momenteel richt ik me op het schrijven van efficiënte, goed leesbare code. 
                                Ik wil mezelf verder verdiepen in frameworks zoals Laravel en React, en leren hoe ik schaalbare en onderhoudbare projecten kan opzetten, zowel technisch als organisatorisch.
                            </p>
                        </div>
                    </li>
                </div>
                <div className="about__contentManagement1">   
                    <li className="about__content1 about__delay--4">
                        <div className="about__contentImgContainer">
                            <FontAwesomeIcon className="about__contentIcon" icon={faUser} />
                        </div>
                        <div className="about__contentTextArea">
                            <h1 className="about__contentTitle">Persoonlijk:</h1>
                            <p className="about__contentInfo">
                                In mijn vrije tijd ben ik graag actief bezig met fitness en golf. Ook game ik graag om te ontspannen. 
                                Ik woon in Medemblik en heb de ambitie om op termijn internationale ervaring op te doen, zowel op persoonlijk als professioneel vlak.
                            </p>
                        </div>
                    </li> 
                </div>
            </div>
        </section>
    );
}

export default About;
