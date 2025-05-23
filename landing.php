<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalkFree - Secure Messaging</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="landing.css">
    <link rel="icon" href="assets/talkfree/favicon.ico" type="image/x-icon">
    <meta name="description" content="TalkFree is a secure messaging platform offering end-to-end encrypted communication.">
    <meta name="keywords" content="Secure Messaging, Encryption, Privacy, TalkFree, RSA-2048, AES-256">
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="landing-modal.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="assets/talkfree/favicon-32x32.png" alt="TalkFree Logo"> TalkFree
            </div>
            <nav>
                <ul>
                    <li><a href="#features" class="hideable-link">Features</a></li>
                    <li><a href="#security" class="hideable-link">Security</a></li>
                    <li><a href="#about" class="hideable-link">About</a></li>
                    <li><a href="login.php" class="cta-button login-button">Log In</a></li>
                    <li><a href="register.php" class="cta-button sign-up-button primary">Sign Up</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Secure Messaging for Everyone</h1>
                <p>End-to-end encrypted communication that keeps your conversations private and secure. 
                Completely open source, giving you full transparency and control over your data.</p>
                <div class="cta-group">
                    <a href="register.php" class="cta-button get-started-button primary">Get Started</a>
                    <a href="#features" class="learn-more-button secondary">Learn More</a>
                </div>
            </div>
            <div class="hero-animation">
                <div class="encryption-animation">
                    <div class="device sender">
                        <div class="device-header">
                            <div class="device-name">Sender</div>
                        </div>
                        <div class="device-content">
                            <div class="message-input">
                                <div class="message-text" id="original-message">Hello, this is a secure message!</div>
                            </div>
                        </div>
                    </div>

                    <div class="encryption-process">
                        <div class="process-step" id="step-1">
                            <div class="step-icon"><i class="fas fa-key"></i></div>
                            <div class="step-line"></div>
                            <div class="step-label">Generate Keys</div>
                        </div>
                        <div class="process-step" id="step-2">
                            <div class="step-icon"><i class="fas fa-lock"></i></div>
                            <div class="step-line"></div>
                            <div class="step-label">Encrypt</div>
                        </div>
                        <div class="process-step" id="step-3">
                            <div class="step-icon"><i class="fas fa-server"></i></div>
                            <div class="step-line"></div>
                            <div class="step-label">Transfer</div>
                        </div>
                        <div class="process-step" id="step-4">
                            <div class="step-icon"><i class="fas fa-unlock"></i></div>
                            <div class="step-line"></div>
                            <div class="step-label">Decrypt</div>
                        </div>
                    </div>

                    <div class="device receiver">
                        <div class="device-header">
                            <div class="device-name">Recipient</div>
                        </div>
                        <div class="device-content">
                            <div class="message-display">
                                <div class="message-text" id="received-message">...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="encryption-data">
                    <div class="data-text" id="encryption-status">Waiting to send message...</div>
                    <div class="encrypted-text" id="encrypted-message"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="container">
            <h2>Why Choose TalkFree?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-lock"></i></div>
                    <h3>End-to-End Encryption</h3>
                    <p>All messages are encrypted on your device and can only be decrypted by the intended recipient.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <h3>Group Messaging</h3>
                    <p>Create secure group conversations with multiple participants while maintaining full encryption.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-key"></i></div>
                    <h3>Key Management</h3>
                    <p>Easy export and import of encryption keys for account recovery and device switching.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Privacy First</h3>
                    <p>No access to your messages or encryption keys - your data remains yours alone.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-code"></i></div>
                    <h3>Open Source</h3>
                    <p>Fully transparent code that anyone can inspect, audit, and contribute to.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-globe"></i></div>
                    <h3>Web-Based</h3>
                    <p>No app installation required - works in any modern web browser.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="security" class="security">
        <div class="container">
            <div class="security-content">
                <h2>Security You Can Trust</h2>
                <p>TalkFree uses modern encryption technologies to ensure your messages remain private:</p>
                <ul class="security-list">
                    <li><i class="fas fa-check-circle"></i> RSA-2048 for key exchange</li>
                    <li><i class="fas fa-check-circle"></i> AES-256 for message encryption</li>
                    <li><i class="fas fa-check-circle"></i> Client-side encryption and decryption</li>
                    <li><i class="fas fa-check-circle"></i> No server access to decryption keys</li>
                    <li><i class="fas fa-check-circle"></i> Open-source code for transparency</li>
                </ul>
                <p class="security-note">Your private keys never leave your device unless you explicitly export them.</p>
            </div>
            <div class="security-image">
                <img src="https://www.okta.com/sites/default/files/styles/tinypng/public/media/image/2021-03/public-key-encryption.png?itok=Bxgj8OXl" alt="Encryption Diagram">
            </div>
        </div>
    </section>

    <section id="about" class="about">
        <div class="container">
            <h2>About TalkFree</h2>
            <p class="about-text">
                TalkFree is an open-source secure messaging platform designed with privacy and security at its core. 
                Our mission is to provide a communication tool that respects user privacy and gives full control 
                to the users over their data.
            </p>
            <div class="github-section">
                <h3><i class="fab fa-github"></i> Open Source</h3>
                <p>
                    TalkFree is completely open source. You can review the code, contribute, or even host your own instance.
                </p>
                <a href="https://github.com/IsaacTalb/talkfree" class="github-button" target="_blank">
                    <i class="fab fa-github"></i> View on GitHub
                </a>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="assets/talkfree/favicon-32x32.png" alt="TalkFree Logo"> TalkFree
                </div>
                <div class="footer-links">
                    <a href="#features">Features</a>
                    <a href="#security">Security</a>
                    <a href="#about">About</a>
                    <a href="https://github.com/IsaacTalb/talkfree" target="_blank">GitHub</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>TalkFree - Secure Messaging for Everyone</p>
            </div>
        </div>
    </footer>

    <!-- Modal structure of Choosing Device -->
    <!-- Login Modal -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div>
                <img style="height:1.5em; width:auto;" src="assets/talkfree/apple-touch-icon.png" alt="TalkFree Logo"> 
                <h1>TalkFree | Log In</h1>
            </div>
            <p>Choose your device for the best user experience:</p>
            <div class="modal-options">
                <a href="mobile/login.php" class="modal-button">Log In via Mobile</a>
                <a href="login.php" class="modal-button">Log In via Laptop</a>
            </div>
        </div>
    </div>

    <!-- Sign Up Modal -->
    <div id="signup-modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div>
                <img style="height:1.5em; width:auto;" src="assets/talkfree/apple-touch-icon.png" alt="TalkFree Logo"> 
                <h1>TalkFree | Sign Up</h1>
            </div>
            <p>Choose your device for the best user experience:</p>
            <div class="modal-options">
                <a href="mobile/register.php" class="modal-button">Sign Up via Mobile</a>
                <a href="register.php" class="modal-button">Sign Up via Laptop</a>
            </div>
        </div>
    </div>

    <!-- Get Started Modal -->
    <div id="get-started-modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div>
                <img style="height:1.5em; width:auto;" src="assets/talkfree/apple-touch-icon.png" alt="TalkFree Logo"> 
                <h1>TalkFree | Get Started</h1>
            </div>
            <p>Choose your device for the best user experience:</p>
            <div class="modal-options">
                <a href="mobile/register.php" class="modal-button">Get Started via Mobile</a>
                <a href="register.php" class="modal-button">Get Started via Laptop</a>
            </div>
        </div>
    </div>

    <script src="landing.js"></script>
    <script src="landing-modal.js"></script>
</body>
</html>