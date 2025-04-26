@extends('components.layout')

@section('title', 'Home')



@section('Content')

<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />



<div id="home" class="hero">
    <div class="hero-content">
      <h1>Find Your Dream Home with Canaanland</h1>
      <p>Connecting property buyers, owners, and tenants with ease.</p>
      <div class="search-bar">
        <input type="text" placeholder="Location">
        <select>
          <option>Property Type</option>
          <option>House</option>
          <option>Lot</option>
          <option>Appartment</option>
          <option>Commercial Space</option>
        </select>
        <input type="text" placeholder="Price Range">
        <button>Search</button>
      </div>
    </div>
</div>

<div id="listings" class="section">
    <h2 style="color: #2c3e50">Listings in La Union!</h2>
    <div class="property-card">
      <img src="{{ asset('img/testhouse1.png') }}" alt="Property 1">
      <div class="info">
        <h3>3BR House in San Carlos</h3>
        <p>₱3,500,000</p>
        <p>Specs</p>
        <p>Location</p>
        <button>View Details</button>
      </div>
    </div>

    <div class="property-card">
      <img src="{{ asset('img/testhouse1.png') }}" alt="Property 2">
      <div class="info">
        <h3>Modern Apartment</h3>
        <p>₱2,800,000</p>
        <p>Specs</p>
        <p>Location</p>
        <button>View Details</button>
      </div>
    </div>

    <div class="property-card">
        <img src="{{ asset('img/testhouse1.png') }}" alt="Property 3">
        <div class="info">
          <h3>Modern Apartment</h3>
          <p>₱2,800,000</p>
          <p>Specs</p>
          <p>Location</p>
          <button>View Details</button>
        </div>
      </div>
  </div> 
</div>

<div class="section">
    <h2 style="color: #2c3e50">Explore Properties in La Union</h2>
    <div id="map" style="height: 500px; width: 100%; margin: 20px 0; border-radius: 8px;"></div>
</div>

<div class="why-choose-us-section">
    <h1 class="section-title">WHY CHOOSE US?</h1>
    
    <p class="section-subtitle">Canaanland Realty Corporation is a SEC Registered company that mainly provides real estate services. Located at San Fernando City, La Union.</p>
    
    <div class="features-container">
        <div class="feature-card">
            <h3>Extensive Listings</h3>
            <p>Discover a wide range of properties across La Union</p>
        </div>
        
        <div class="feature-card">
            <h3>Easy Comparison</h3>
            <p>Effortlessly compare properties to find your perfect match</p>
        </div>
        
        <div class="feature-card">
            <h3>Reliable Service</h3>
            <p>Experience trustworthy support throughout your property journey</p>
        </div>
        
        <div class="feature-card">
            <h3>Local Expertise</h3>
            <p>Benefit from our team's in-depth knowledge of the La Union market</p>
        </div>
    </div>
</div>

<div id="contact" class="contact">
    <div class="contact-container">
        <!-- Follow Us Section -->
        <div class="contact-column">
            <h2>Follow Us</h2>
            <p>Stay connected!</p>
            <div class="social-links">
                <a href="mailto:carecorp010813@gmail.com">carecorp010813@gmail.com</a>
                <a href="#">canaanland/Facebook</a>
                <a href="#">canaanland/Telegram</a>
                <a href="#">canaanland/Viber</a>
            </div>
            <p class="copyright">© 2025 Canaanland Realty Corp. <br>All Rights Reserved.</p>
        </div>

        <!-- Contact Our Team Section -->
        <div class="contact-column">
            <h2>Contact Our Team</h2>
            <p>Address: CCC, Bangkusay, San Fernando, Launion</p>
            <p>0927 273 9616</p>
            <p>123-654-754</p>
            <p>123-456-890</p>
            <p>1234567890</p>
        </div>

        <!-- Contact Form Section -->
        <div class="contact-column">
            <h2>Contact Form</h2>
            <form class="contact-form">
                <div class="form-row">
                    <input type="text" placeholder="First name" required>
                    <input type="text" placeholder="Last name" required>
                </div>
                <input type="email" placeholder="Email" required>
                <textarea placeholder="Message" rows="4" required></textarea>
                <button type="submit" class="send-message">Send Message</button>
            </form>
        </div>
    </div>
</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the map - set coordinates to La Union, Philippines
        const map = L.map('map').setView([16.6162, 120.3172], 12);
        
        // Add the OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Add markers for sample properties in La Union
        // Sample property 1 - San Carlos
        L.marker([16.6162, 120.3172]).addTo(map)
            .bindPopup('<b>3BR House in San Carlos</b><br>₱3,500,000<br><button onclick="viewDetails(1)">View Details</button>')
            .openPopup();
        
        // Sample property 2 - nearby area
        L.marker([16.6262, 120.3272]).addTo(map)
            .bindPopup('<b>Modern Apartment</b><br>₱2,800,000<br><button onclick="viewDetails(2)">View Details</button>');
            
        // Sample property 3 - another nearby area
        L.marker([16.6062, 120.3072]).addTo(map)
            .bindPopup('<b>Commercial Space</b><br>₱4,200,000<br><button onclick="viewDetails(3)">View Details</button>');
    });
    
    // Function to handle viewing property details
    function viewDetails(propertyId) {
        // You can replace this with actual navigation to property details
        alert('Viewing property #' + propertyId);
        // Or use: window.location.href = '/property/' + propertyId;
    }
</script>
@endsection