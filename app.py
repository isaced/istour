from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask import render_template
from flask import request,redirect,url_for

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
    return render_template('list.html', city_list=city_list)

@app.route('/city_add', methods=['POST'])
def city_add():
    city_name = request.form['city_name']
    print(city_name)
    if city_name:
        city = models.City(city_name)
        db.session.add(city)
        db.session.commit()
    return redirect(url_for('cities'))


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