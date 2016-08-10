from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask import render_template

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///test.db'

db = SQLAlchemy(app)
import models
# from models import City

db.create_all()

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/cities')
def cities():
    city_list = models.City.query.all()
    print(city_list)
    return render_template('list.html')

@app.route('/categories')
def categories():
    return render_template('list.html')

@app.route('/places')
def places():
    return render_template('list.html')

@app.route('/places-edit')
def places_edit():
    return render_template('places-edit.html')

if __name__ == '__main__':
    app.debug = True
    app.run()