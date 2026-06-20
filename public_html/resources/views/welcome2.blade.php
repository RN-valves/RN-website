<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="canonical" href="{{ url()->current() }}">
  <title>RN Valves & Faucets</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <style>
    body {
  margin: 0;
  font-family: 'Roboto', sans-serif;
  line-height: 1.6;
  background-color: #fff;
  color: #333;
}

header {
  background: #003057;
  color: white;
}

.top-bar {
  display: flex;
  justify-content: space-between;
  padding: 0.5em 1em;
  background: #001d35;
  font-size: 0.9em;
}

.top-bar a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
}

.main-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1em;
}

.main-nav ul {
  list-style: none;
  display: flex;
  gap: 1em;
  margin: 0;
}

.main-nav a {
  color: white;
  text-decoration: none;
  font-weight: 500;
}

.hero {
  position: relative;
  text-align: center;
  background: #e6f0f5;
  padding: 2em 0;
}

.hero-text h1 {
  font-size: 2.5rem;
  color: #003057;
}

.highlight {
  color: #ffd700;
}

.product-categories,
.new-arrivals,
.offers,
.updates,
.contact-form {
  padding: 2em 1em;
  max-width: 1200px;
  margin: auto;
}

.category-grid,
.product-grid {
  display: flex;
  gap: 1em;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  padding-bottom: 1em;
}

.category,
.product {
  flex: 0 0 auto;
  scroll-snap-align: start;
  background: #f9f9f9;
  padding: 1em;
  border: 1px solid #ddd;
  border-radius: 8px;
  text-align: center;
  min-width: 250px;
}

.updates-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1em;
}

.category img,
.product img,
.update img {
  width: 100%;
  height: auto;
  border-radius: 4px;
}

.offers .offer-banner img {
  width: 100%;
  border-radius: 8px;
}

.contact-form form {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1em;
  max-width: 800px;
  margin: auto;
}

.contact-form textarea {
  grid-column: span 2;
  height: 100px;
  resize: vertical;
}

.contact-form button {
  grid-column: span 2;
  padding: 0.75em;
  background: #003057;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

footer {
  background: #003057;
  color: white;
  padding: 2em 1em 1em;
}

.footer-top {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1em;
  max-width: 1200px;
  margin: auto;
}

.footer-bottom {
  text-align: center;
  font-size: 0.85em;
  margin-top: 1em;
  border-top: 1px solid rgba(255, 255, 255, 0.2);
  padding-top: 1em;
}

.footer-top ul {
  list-style: none;
  padding: 0;
}

.footer-top ul li a {
  color: #fff;
  text-decoration: none;
  display: block;
  margin-bottom: 0.5em;
}

@media (max-width: 768px) {
  .main-nav ul {
    flex-direction: column;
    gap: 0.5em;
  }

  .contact-form form {
    grid-template-columns: 1fr;
  }

  .contact-form button,
  .contact-form textarea {
    grid-column: span 1;
  }

  .category,
  .product {
    min-width: 200px;
  }
}
.scroll-x {
  display: flex;
  overflow-x: auto;
  gap: 20px;
  padding-bottom: 10px;
  scroll-snap-type: x mandatory;
}

.scroll-x > * {
  flex: 0 0 auto;
  scroll-snap-align: start;
}

.category, .product {
  min-width: 250px;
  border: 1px solid #ddd;
  padding: 10px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: transform 0.2s;
}

.category:hover, .product:hover {
  transform: translateY(-5px);
}

.category img, .product img {
  width: 100%;
  border-radius: 5px;
}


  </style>
</head>
<body>
  <header>
    <div class="top-bar">
      <span>1800 123 400 400 | enquiry@rnvalves.com</span>
      <a href="#">Become a Dealer</a>
    </div>
    <nav class="main-nav">
      <div class="logo">
        <img src="logo.png" alt="RN Valves & Faucets">
      </div>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Our Products</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Catalogue</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-text">
      <h1>RN THE PULSE OF <span class="highlight">WATER</span></h1>
    </div>
    <img src="/images/hero-image.jpg" alt="Main Banner">
  </section>

  <section class="product-categories">
    <h2>Main Categories</h2>
    <div class="category-grid scroll-x">
      <div class="category">
        <img src="/images/ptmt.jpg" alt="PTMT Faucets">
        <h4>PTMT/High Grade Engineering Polymer Faucets</h4>
        <a href="#">View All</a>
      </div>
      <div class="category">
        <img src="/images/cp.jpg" alt="CP Faucets">
        <h4>CP Faucets</h4>
        <a href="#">View All</a>
      </div>
      <div class="category">
        <img src="/images/showers.jpg" alt="Showers">
        <h4>Showers</h4>
        <a href="#">View All</a>
      </div>
      <div class="category">
        <img src="/images/ball-valves.jpg" alt="Ball Valves">
        <h4>Ball Valves</h4>
        <a href="#">View All</a>
      </div>
    </div>
  </section>

  <section class="new-arrivals">
    <h2>New Arrival Products</h2>
    <div class="product-grid scroll-x">
      <div class="product">
        <img src="/images/new1.jpg" alt="Product 1">
        <p>2 in 1 Bib Cock Foam Flow With Flange</p>
        <span>₹ 400</span>
      </div>
      <div class="product">
        <img src="/images/new2.jpg" alt="Product 2">
        <p>Nozzle Bib Cock With Flange</p>
        <span>₹ 260</span>
      </div>
      <div class="product">
        <img src="/images/new3.jpg" alt="Product 3">
        <p>Pillar Cock Tall Body Foam Flow</p>
        <span>₹ 572</span>
      </div>
      <div class="product">
        <img src="/images/new4.jpg" alt="Product 4">
        <p>Center Hole Basin Mixer</p>
        <span>₹ 1365</span>
      </div>
    </div>
  </section>

  <section class="offers">
    <h2>Our Offers</h2>
    <div class="offer-banner">
      <img src="/images/offer.jpg" alt="45% Off">
    </div>
  </section>

  <section class="updates">
    <h2>Latest Updates</h2>
    <p>With over 24 years of industry experience, RN Valves & Faucets is not just a brand...</p>
    <div class="updates-grid">
      <div class="update">
        <img src="/images/update1.jpg" alt="Update 1">
        <p>3 Reasons To Install Automatic Faucets</p>
      </div>
      <div class="update">
        <img src="/images/update2.jpg" alt="Update 2">
        <p>Numerous Advantages of Kitchen Renovation</p>
      </div>
      <div class="update">
        <img src="/images/update3.jpg" alt="Update 3">
        <p>Touchless Dispensers for Hygiene</p>
      </div>
    </div>
  </section>

  <section class="contact-form">
    <h2>Looking For Bathroom Solutions? Let's Talk</h2>
    <form>
      <input type="text" placeholder="Full Name">
      <input type="email" placeholder="Email Address">
      <input type="text" placeholder="Company Name">
      <input type="text" placeholder="Contact Number">
      <select>
        <option>Select Profession</option>
        <option>Dealer</option>
        <option>Architect</option>
      </select>
      <input type="text" placeholder="ZIP Code">
      <textarea placeholder="Message"></textarea>
      <button type="submit">Send Enquiry</button>
    </form>
  </section>

  <footer>
    <div class="footer-top">
      <div>
        <h4>Products</h4>
        <ul>
          <li><a href="#">CP Faucets</a></li>
          <li><a href="#">Showers</a></li>
        </ul>
      </div>
      <div>
        <h4>Our Company</h4>
        <ul>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4>Contact</h4>
        <p>B-98, Ghaziabad, India</p>
        <p>enquiry@rnvalves.com</p>
        <p>1800 123 400 400</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 RN Valves & Faucets. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
