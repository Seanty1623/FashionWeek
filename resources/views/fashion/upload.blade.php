@extends('fashion.layout')

@section('title', 'Submit Your Look - Fashion Week')

@section('content')
    <div class="upload-page">
        <h1 class="page-title">Submit Your <span>Look</span></h1>
        <p class="page-subtitle">Get outfit inspiration or upload your own fashion!</p>

        <!-- Randomizer Section -->
        <div class="randomizer-section">
            <h2 class="randomizer-title">🎲 Outfit Randomizer</h2>
            <p class="randomizer-subtitle">Click the button to get a complete outfit idea!</p>
            
            <button class="randomize-btn" onclick="randomize()">
                🎲 RANDOMIZE OUTFIT
            </button>

            <div class="random-result" id="randomResult">
                <div class="outfit-items">
                    <div class="outfit-item">
                        <div class="outfit-emoji" id="topEmoji">👕</div>
                        <div class="outfit-label">Top</div>
                        <div class="outfit-name" id="topName">T-Shirt</div>
                    </div>
                    <div class="outfit-item">
                        <div class="outfit-emoji" id="bottomEmoji">👖</div>
                        <div class="outfit-label">Bottom</div>
                        <div class="outfit-name" id="bottomName">Jeans</div>
                    </div>
                    <div class="outfit-item">
                        <div class="outfit-emoji" id="footwearEmoji">👟</div>
                        <div class="outfit-label">Footwear</div>
                        <div class="outfit-name" id="footwearName">Sneakers</div>
                    </div>
                </div>
                <p class="result-subtitle">This could be your outfit!</p>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="upload-form">
            <h3 class="form-title">📸 Upload Your Own Look</h3>
            
            <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="description">Description (Optional)</label>
                    <textarea name="description" id="description" rows="3" placeholder="Describe your outfit..."></textarea>
                </div>
                
                <div class="form-group">
                    <label>Upload Photo</label>
                    <div class="file-input-wrapper">
                        <label for="photo" class="file-input-label" id="fileLabel">
                            <span>📁 Click to select image</span>
                        </label>
                        <input type="file" name="photo" id="photo" accept="image/*" required>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Upload My Look</button>
            </form>

            <div class="restrictions">
                <h4>⚠️ Dress Code Notice</h4>
                <p> Caps, Hats, Shorts, Leggings, Skirts, Dresses, Rompers, Jumpsuits, Bathing Suits, and Swimwear are NOT allowed</p>
            </div>
        </div>
    </div>

    <script>
        // All clothing options (school-appropriate only)
        const clothingOptions = {
            top: [
                { emoji: '👕', name: 'T-Shirt' },
                { emoji: '👔', name: 'Polo Shirt' },
                { emoji: '🧥', name: 'Long Sleeve' },
                { emoji: '🧥', name: 'Hoodie' },
                { emoji: '🧶', name: 'Sweater' },
                { emoji: '🧥', name: 'Jacket' },
                { emoji: '👔', name: 'Blazer' },
                { emoji: '🎽', name: 'Vest' }
            ],
            bottom: [
                { emoji: '👖', name: 'Jeans' },
                { emoji: '👖', name: 'Pants' },
                { emoji: '👖', name: 'Joggers' },
                { emoji: '👖', name: 'Cargo Pants' },
                { emoji: '👖', name: 'Chinos' },
                { emoji: '👖', name: 'Sweatpants' },
                { emoji: '👖', name: 'Track Pants' },
                { emoji: '👖', name: 'Khakis' },
                { emoji: '👖', name: 'Corduroys' },
                { emoji: '👖', name: 'Overalls' }
            ],
            footwear: [
                { emoji: '👟', name: 'Sneakers' },
                { emoji: '👢', name: 'Boots' },
                { emoji: '👞', name: 'Dress Shoes' },
                { emoji: '👞', name: 'Loafers' },
                { emoji: '👟', name: 'Running Shoes' },
                { emoji: '👟', name: 'Basketball Shoes' },
                { emoji: '👢', name: 'Work Boots' },
                { emoji: '👟', name: 'Skate Shoes' },
                { emoji: '👞', name: 'Oxford Shoes' },
                { emoji: '👟', name: 'Hiking Boots' },
                { emoji: '👞', name: 'Leather Shoes' }
            ]
        };

        function randomize() {
            const resultBox = document.getElementById('randomResult');
            
            // Hide result first
            resultBox.classList.remove('show');

            // Get random item from each category
            const topItem = clothingOptions.top[Math.floor(Math.random() * clothingOptions.top.length)];
            const bottomItem = clothingOptions.bottom[Math.floor(Math.random() * clothingOptions.bottom.length)];
            const footwearItem = clothingOptions.footwear[Math.floor(Math.random() * clothingOptions.footwear.length)];

            // Show result after short delay
            setTimeout(() => {
                document.getElementById('topEmoji').textContent = topItem.emoji;
                document.getElementById('topName').textContent = topItem.name;
                
                document.getElementById('bottomEmoji').textContent = bottomItem.emoji;
                document.getElementById('bottomName').textContent = bottomItem.name;
                
                document.getElementById('footwearEmoji').textContent = footwearItem.emoji;
                document.getElementById('footwearName').textContent = footwearItem.name;
                
                resultBox.classList.add('show');
            }, 300);
        }

        // File input display
        document.getElementById('photo').addEventListener('change', function(e) {
            const label = document.getElementById('fileLabel');
            if (e.target.files.length > 0) {
                label.innerHTML = '<span>✅ ' + e.target.files[0].name + '</span>';
                label.classList.add('has-file');
            } else {
                label.innerHTML = '<span>📁 Click to select image</span>';
                label.classList.remove('has-file');
            }
        });
    </script>
@endsection

