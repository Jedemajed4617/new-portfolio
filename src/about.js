import "./about.css";
import React from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faFaceLaugh } from "@fortawesome/free-regular-svg-icons";
import { faClipboard } from "@fortawesome/free-regular-svg-icons";
import { faCompass } from "@fortawesome/free-regular-svg-icons";
import { faNewspaper } from "@fortawesome/free-regular-svg-icons";

function About() {
    return (
        <section className="about">
            <div class="about__contentManagement">   
                <li class="about__content">
                    <div class="about__contentImgContainer">
                        <FontAwesomeIcon class="about__contentIcon" icon={faNewspaper} />
                    </div>
                    <div class="about__contentTextArea">
                        <h1 class="about__contentTitle">Introductie:</h1>
                        <p class="about__contentInfo">
                            Mijn naam is Tygo. Ik ben 21 jaar oud en volg momenteel een opleiding tot full stack software developer. 
                            In mijn vrije tijd geniet ik van fitness, golf, tennis en coderen.
                        </p>
                    </div>
                </li>
            </div>
            <div class="about__contentManagement1">   
                <li class="about__content1">
                    <div class="about__contentImgContainer">
                        <FontAwesomeIcon class="about__contentIcon" icon={faCompass} />
                    </div>
                    <div class="about__contentTextArea">
                        <h1 class="about__contentTitle">Wat ik wil bereiken:</h1>
                        <p class="about__contentInfo">
                            Ik streef ernaar om zoveel mogelijk programmeertalen te leren en uitgebreide kennis op te doen over het vakgebied waarin ik momenteel studeer. 
                            Daarnaast ben ik geïnteresseerd in de zakelijke kant van softwareontwikkeling, met de ambitie om in de toekomst mijn eigen bedrijf te starten.
                        </p>
                    </div>
                </li>
            </div>
            <div class="about__contentManagement">   
                <li class="about__content">
                    <div class="about__contentImgContainer">
                        <FontAwesomeIcon class="about__contentIcon" icon={faClipboard} />
                    </div>
                    <div class="about__contentTextArea">
                        <h1 class="about__contentTitle">Wat ik wil leren:</h1>
                        <p class="about__contentInfo">
                            Op dit moment richt ik me op het verbeteren van mijn code door deze duidelijker en efficiënter te schrijven. 
                            Ik wil graag projecten ontwikkelen met Lua, Laravel en React, en me verder verdiepen in de zakelijke aspecten van de softwareontwikkeling.
                        </p>
                    </div>
                </li>
            </div>
            <div class="about__contentManagement1">   
                <li class="about__content1">
                    <div class="about__contentImgContainer">
                        <FontAwesomeIcon class="about__contentIcon" icon={faFaceLaugh} />
                    </div>
                    <div class="about__contentTextArea">
                        <h1 class="about__contentTitle">Over mij</h1>
                        <p class="about__contentInfo">
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