import "./home.css";

function Home() {
    return (
        <section class="homeContent" style={{ backgroundColor: '#1E1E1E' }}>
            <div class="flow">
                <div class="container">
                    <div class="grower animate">
                        <div id="nameText" class="trans">
                            <h1 class="eerste">My name is,</h1>
                            <div class="tranq">
                                <h1 class="tweede">Tygo Jedema</h1>
                                <h1 class="derde">I am a </h1>
                            </div>
                            <h1 class="vierde">Fullstack Developer</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default Home;