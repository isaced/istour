from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask import render_template
from flask import request,redirect,url_for

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///test.db'

db = SQLAlchemy(app)
import models

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/cities')
def cities():
    obj_list = models.City.query.all()
    return render_template('list.html',title='城市', obj_list=obj_list)

@app.route('/city_add', methods=['POST'])
def city_add():
    print('Call city_add....')
    city_name = request.form['obj_name']
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
    print('category_name')
    category_name = request.form.get('obj_name')
    print(category_name)
    if category_name:
        category = models.Category(category_name)
        db.session.add(category)
        db.session.commit()
    return redirect(url_for('categories'))

@app.route('/places')
def places():
    obj_list = models.Place.query.all()
    return render_template('list.html',title='景点',obj_list=obj_list)

@app.route('/place_edit/', methods=['POST','GET'])
@app.route('/place_edit/<int:place_id>/', methods=['POST','GET'])
def place_edit(place_id=None):
    print(request.method)
    if request.method == 'POST':
        place = None
        if place_id:
            # 修改
            place = models.Place.query.filter(models.Place.id == place_id).first()
        else:
            # 新增
            place = models.Place()

        place.name = request.form.get('place_name')
        place.postion = request.form.get('place_position')
        place.city_id = request.form.get('place_city_id')
        place.category_id = request.form.get('place_category_id')
        place.description = request.form.get('place_desc')
        place.excerpt = request.form.get('place_excerpt')

        if not place_id:
            db.session.add(place)
        db.session.commit()

        return redirect(url_for('places'))
    else:
        city_list = models.City.query.all()
        category_list = models.Category.query.all()

        if place_id:
            place = models.Place.query.filter(models.Place.id == place_id).first()
            print(place,place.id)
            return render_template('places-edit.html',title='编辑景点',place=place,city_list=city_list,category_list=category_list)
        else:
            return render_template('places-edit.html',title='新建景点',city_list=city_list,category_list=category_list)

@app.route('/delete/city/<int:city_id>')
@app.route('/delete/category/<int:category_id>')
@app.route('/delete/place/<int:place_id>')
def delet_obj(city_id=None,category_id=None,place_id=None):
    if city_id:
        obj = models.City.query.filter(models.City.id == city_id).first()
        db_session = db.session.object_session(obj)
        db_session.delete(obj)
        db_session.commit()
        return redirect(url_for('cities'))
    elif category_id:
        obj = models.Category.query.filter(models.Category.id == category_id).first()
        db_session = db.session.object_session(obj)
        db_session.delete(obj)
        db_session.commit()
        return redirect(url_for('categories'))
    elif place_id:
        obj = models.Place.query.filter(models.Place.id == place_id).first()
        db_session = db.session.object_session(obj)
        db_session.delete(obj)
        db_session.commit()
        return redirect(url_for('places'))
    else:
        redirect(url_for('index'))


@app.route('/edit/city/<int:city_id>/<city_name>')
@app.route('/edit/category/<int:category_id>/<category_name>')
def edit_obj(city_id=None,city_name=None,category_id=None,category_name=None):
    if city_id:
        obj = models.City.query.filter(models.City.id == city_id).first()
        obj.name = city_name;
        db_session = db.session.object_session(obj)
        db_session.commit()
        return redirect(url_for('cities'))
    elif category_id:
        obj = models.Category.query.filter(models.Category.id == category_id).first()
        obj.name = category_name;
        db_session = db.session.object_session(obj)
        db_session.commit()
        return redirect(url_for('categories'))
    else:
        redirect(url_for('index'))

if __name__ == '__main__':
    app.debug = True
    app.run()