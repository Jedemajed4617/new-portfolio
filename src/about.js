import "./about.css";
import React, { useState, useEffect } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faFaceLaugh, faClipboard, faCompass, faNewspaper } from "@fortawesome/free-regular-svg-icons";

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
            <div className="about__contentManagement">   
                <li className="about__content">
                    <div className="about__contentImgContainer">
                        <FontAwesomeIcon className="about__contentIcon" icon={faNewspaper} />
                    </div>
                    <div className="about__contentTextArea">
                        <h1 className="about__contentTitle">Introductie:</h1>
                        <p className="about__contentInfo">
                            Mijn naam is Tygo. Ik ben {leeftijd} jaar oud en volg momenteel een opleiding tot full stack software developer. 
                            Ik ben geïnteresseerd in het ontwikkelen van webapplicaties en het leren van nieuwe programmeertalen.
                        </p>
                    </div>
                </li>
            </div>
            <div className="about__contentManagement1">   
                <li className="about__content1">
                    <div className="about__contentImgContainer">
                        <FontAwesomeIcon className="about__contentIcon" icon={faCompass} />
                    </div>
                    <div className="about__contentTextArea">
                        <h1 className="about__contentTitle">Wat ik wil bereiken:</h1>
                        <p className="about__contentInfo">
                            Ik streef ernaar om zoveel mogelijk programmeertalen te leren en uitgebreid kennis op te doen over het vakgebied waarin ik momenteel studeer. 
                            Daarnaast ben ik geïnteresseerd in de zakelijke kant van softwareontwikkeling, met de ambitie om in de toekomst mijn eigen bedrijf te starten.
                        </p>
                    </div>
                </li>
            </div>
            <div className="about__contentManagement">   
                <li className="about__content">
                    <div className="about__contentImgContainer">
                        <FontAwesomeIcon className="about__contentIcon" icon={faClipboard} />
                    </div>
                    <div className="about__contentTextArea">
                        <h1 className="about__contentTitle">Wat ik wil leren:</h1>
                        <p className="about__contentInfo">
                            Op dit moment richt ik me op het verbeteren van mijn code door deze duidelijker en efficiënter te schrijven. 
                            Ik wil graag projecten ontwikkelen met Laravel en React, en me verder verdiepen in de zakelijke aspecten van de softwareontwikkeling.
                        </p>
                    </div>
                </li>
            </div>
            <div className="about__contentManagement1">   
                <li className="about__content1">
                    <div className="about__contentImgContainer">
                        <FontAwesomeIcon className="about__contentIcon" icon={faFaceLaugh} />
                    </div>
                    <div className="about__contentTextArea">
                        <h1 className="about__contentTitle">Over mij</h1>
                        <p className="about__contentInfo">
                            Naast fitness en golf vind ik het ook leuk om te gamen in mijn vrije tijd. 
                            Ik woon nog bij mijn ouders in Medemblik, en ben van plan om in de toekomst te verhuizen naar het buitenland.
                        </p>
                    </div>
                </li> 
            </div>
        </section>
    );
}

export default About;
