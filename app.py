from flask import Flask
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///test.db'

db = SQLAlchemy(app)
import models

@app.route('/')
def hello_world():
    return 'Hello World!'

if __name__ == '__main__':
    # app.debug = True
    app.run()