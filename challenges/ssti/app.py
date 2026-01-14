from flask import Flask, request, render_template_string

app = Flask(__name__)

TEMPLATE = '''
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎨 GreetingCard Generator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Georgia', serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 600px;
        }
        
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 30px;
            text-align: center;
        }
        
        .card-header h1 {
            color: white;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .card-body {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            color: #764ba2;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #764ba2;
        }
        
        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .greeting-result {
            margin-top: 30px;
            padding: 30px;
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border-radius: 15px;
            text-align: center;
        }
        
        .greeting-result h2 {
            color: #764ba2;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        .greeting-result p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .decorations {
            font-size: 2rem;
            margin: 10px 0;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>🎨 GreetingCard Generator</h1>
            </div>
            
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Enter Your Name:</label>
                        <input type="text" id="name" name="name" placeholder="e.g., John Doe" value="{{ name_value }}">
                    </div>
                    <button type="submit">✨ Generate Greeting Card</button>
                </form>
                
                {% if greeting %}
                <div class="greeting-result">
                    <div class="decorations">🎉 🎊 🎈</div>
                    <h2>Hello, ''' + '''{{ greeting }}''' + '''!</h2>
                    <p>Welcome to our special greeting card service!</p>
                    <div class="decorations">💐 🌟 💖</div>
                </div>
                {% endif %}
            </div>
        </div>
        
        <footer>
            Made with ❤️ using Flask & Jinja2
        </footer>
    </div>
</body>
</html>
'''

@app.route('/', methods=['GET', 'POST'])
def index():
    name_value = ''
    greeting = None
    
    if request.method == 'POST':
        name = request.form.get('name', '')
        name_value = name
        
        # VULNERABLE: SSTI - User input directly rendered in template!
        # The greeting is rendered as part of the template
        vulnerable_template = TEMPLATE.replace('{{ greeting }}', name)
        return render_template_string(vulnerable_template, name_value=name_value, greeting=name)
    
    return render_template_string(TEMPLATE, name_value=name_value, greeting=greeting)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80, debug=False)
