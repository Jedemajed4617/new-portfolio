import "./about.css";
import React from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faFaceLaugh, faClipboard, faCompass, faNewspaper } from "@fortawesome/free-regular-svg-icons";

function About() {
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
                            Mijn naam is Tygo. Ik ben 21 jaar oud en volg momenteel een opleiding tot full stack software developer. 
                            In mijn vrije tijd geniet ik van fitness, golf, tennis en coderen.
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
                            Ik streef ernaar om zoveel mogelijk programmeertalen te leren en uitgebreide kennis op te doen over het vakgebied waarin ik momenteel studeer. 
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
                            Ik wil graag projecten ontwikkelen met Lua, Laravel en React, en me verder verdiepen in de zakelijke aspecten van de softwareontwikkeling.
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
                            Ik woon nog bij mijn ouders in Medemblik, samen met onze twee honden, in een gezellig huis in het centrum.
                        </p>
                    </div>
                </li>
            </div>
        </section>
    );
}

export default About;
