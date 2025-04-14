# TalkFree

TalkFree is an open-source secure messaging platform designed with privacy and security at its core. It provides end-to-end encrypted communication that keeps your conversations private and secure.

> 🪙 **Acknowledgment to Temcrypta's Origins — [Temcrypta](https://github.com/temal32/temcrypta)** — the cornerstone in developing a secure, open, and private communication platform.

## ✨ What’s New in TalkFree

TalkFree builds upon the original Temcrypta project with **major enhancements**:
- 🖥️📱 **Device Flexibility**: Seamlessly switch between your mobile device and personal laptop.
- 🗃️ **MySQL Support**: Migrated from SQLite (used in Temcrypta) to MySQL for improved scalability and reliability.
- 🔐 **Protected Environment Variables**: Improved configuration security via `.env` file protection.
- 🌐 **Burmese Language Friendly**: TalkFree is now easier to use for Burmese speakers, and full multi-language support is coming soon!

Feel free to **contribute**, open **issues**, submit **pull requests**, and help improve TalkFree for everyone.


## ✨ Features

- **End-to-End Encryption**: All messages are encrypted on your device and can only be decrypted by intended recipients
- **RSA-2048 & AES-256**: Industry-standard encryption algorithms for secure communications
- **Group Messaging**: Create secure group conversations with multiple participants while maintaining full encryption
- **Key Management**: Export and import encryption keys for account recovery and device switching
- **Web-Based**: No app installation required - works in any modern web browser
- **Open Source**: Fully transparent code that anyone can inspect, audit, and contribute to

## 🔒 Security

TalkFree uses modern cryptographic technologies to ensure your messages remain private:

- RSA-2048 encryption for key exchange
- AES-256 for message encryption
- Client-side encryption and decryption
- No server access to decryption keys
- Private keys never leave your device unless you explicitly export them

## 🚀 Installation

### Prerequisites

- PHP 7.4 or higher (Tested on PHP 8)
- phpMyAdmin (MySQL)
- Web server (e.g. Nginx, Apache)

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/IsaacTalb/talkfree.git
   ```
2. Set up the database:
   ```bash
   cp .env.example .env
   ```
3. Configure your .env with MySQL credentials and other settings(I've also provided sql file on database_and_queries folders).
4. Run the app locally:
   ```bash
   php -S localhost:8000
   ```
5. Open your browser and go to: http://localhost:8000


## 🛡️ Technical Implementation
TalkFree implements industry-standard encryption:
- Client-side RSA key pair generation (2048-bit)
- AES-256-GCM for symmetric message encryption
- Secure key exchange using recipient's public key
- Zero server-side access to decryption keys or plaintext messages

### Encryption Flow
1. Each message is encrypted with a random AES key
2. The AES key is encrypted with the recipient's public RSA key
3. Only the encrypted message and encrypted AES key are transmitted
4. Recipients decrypt the AES key using their private RSA key
5. The decrypted AES key is used to decrypt the message

## ⚠️ Disclaimer
While TalkFree uses strong encryption standards, no system can guarantee absolute security. Users should follow best security practices:

- Keep your private keys safe
- Use strong, unique passwords
- Be cautious about who you communicate with
- Regularly update your system and browser

<p align="center"> Made with ❤️ for privacy and security — now with Burmese-friendly support 🇲🇲 </p>
