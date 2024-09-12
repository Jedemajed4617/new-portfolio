import "./contact.css";
import React from 'react';

function Contact() {
    return (
        <div class="contact">
            <div class="contact-container">
                <div class="contact-info">
                    <div>
                        <span>Adres:</span>
                        <a target="_blank" href="https://www.google.com/maps/place/Koningshof+25,+1671+AM+Medemblik/@52.7733593,5.1066674,17z/data=!3m1!4b1!4m6!3m5!1s0x47c8b02e769dd293:0xeba2b50848fa3b48!8m2!3d52.7733561!4d5.1092423!16s%2Fg%2F11c19d4cs3?entry=ttu&g_ep=EgoyMDI0MDkxMC4wIKXMDSoASAFQAw%3D%3D">Koningshof 25, 1671AM te Medemblik</a>
                    </div>
                    <div>
                        <span>KVK:</span>
                        <a target="_blank" href="https://www.kvk.nl/bestellen/#/93297173000058852964">93297173</a>
                    </div>
                    <div>
                        <span>Telefoon:</span>
                        <a href="tel:+31628856671">+31 6 28856671</a>
                    </div>
                    <div>
                        <span>Email:</span>
                        <a href="mailto:tygoiedema@gmail.com">tygoiedema@gmail.com</a>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Contact;