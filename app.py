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
    obj_list = models.City.query.all()
    return render_template('list.html',title='城市', obj_list=obj_list)

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
    obj_list = models.Category.query.all()
    return render_template('list.html',title='分类',obj_list=obj_list)

@app.route('/category_add', methods=['POST'])
def category_add():
    category_name = request.form['obj_name']
    if category_name:
        category = models.Category(category_name)
        db.session.add(category)
        db.session.commit()
    return redirect(url_for('categories'))

@app.route('/places')
def places():
    obj_list = models.Place.query.all()
    return render_template('list.html',title='景点',obj_list=obj_list)

@app.route('/places-edit/')
@app.route('/places-edit/<int:place_id>/')
def places_edit(place_id=None, methods=['GET', 'POST']):
    print('~~~~aa')
    city_list = models.City.query.all()
    category_list = models.Category.query.all()
    print(request.method)
    if request.method == 'POST':
        print('aaa')
        # 修改
        place = models.Place()
        place.name = request.form['place_name']
        place.postion = request.form['place_position']
        place.city_id = request.form['place_city_id']
        place.category_id = request.form['place_category_id']
        place.description = request.form['place_desc']
        place.excerpt = request.form['place_excerpt']
        db.session.add(place)
        db.session.commit()

        # 新增

        return redirect(url_for('places'))
    else:
        if place_id:
            place = models.Place.query.filter(models.Place.id == place_id).first()
            return render_template('places-edit.html',title='编辑景点',place=place,city_list=city_list,category_list=category_list)
        else:
            return render_template('places-edit.html',title='新建景点',city_list=city_list,category_list=category_list)

if __name__ == '__main__':
    app.debug = True
    app.run()