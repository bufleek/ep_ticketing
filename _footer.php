<footer>
    <div class="container">
        <p>&copy; 2024 PlanPal. All rights reserved.</p>
        <div class="social-links">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
        </div>
        <div class="contact-form mt-30">
            <br />
            <h3>Contact Us</h3>
            <form action="contact.php" method="POST" id="contact">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn-primary">Send</button>
            </form>
        </div>
    </div>
</footer>
</body>
</html>
