<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Left Side Text Box</title>
    <style>
        /* Main container */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Button to open the box */
        .open-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #004A77;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Hidden box styles */
        .side-box {
            position: fixed;
            top: 0;
            left: -300px; /* Initially hidden off-screen */
            width: 300px;
            height: 100%;
            background-color: #f3f3f3;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            padding: 20px;
            transition: left 0.3s ease-in-out;
            overflow-y: auto;
        }

        /* Box content */
        .side-box h2 {
            color: #004A77;
        }

        /* Show the box when active */
        .side-box.active {
            left: 0; /* Slide in from the left */
        }

        /* Close button */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #FF3E3E;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 30px;
            height: 30px;
            font-size: 18px;
            line-height: 30px;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Button to open the side box -->
<button class="open-btn" onclick="toggleBox()">Open Text Box</button>

<!-- Left side text box -->
<div class="side-box" id="sideBox">
    <button class="close-btn" onclick="toggleBox()">&times;</button>
    <h2>Left Side Box</h2>
    <p>This is a text box that appears on the left side of the page. You can add more content here as needed.</p>
</div>

<script>
    // Function to toggle the side box visibility
    function toggleBox() {
        const box = document.getElementById('sideBox');
        box.classList.toggle('active');
    }
</script>

</body>
</html>
