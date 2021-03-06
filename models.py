from app import db

class City(db.Model):
    __tablename__ = 'City'
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    name = db.Column(db.String(50), unique=True)

    def __init__(self, name=None):
            self.name = name

    def __repr__(self):
        return '<City %r>' % (self.name)

class Place(db.Model):
    __tablename__ = 'Place'
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    name = db.Column(db.String(50), unique=True)
    city_id = db.Column(db.Integer, db.ForeignKey('City.id'))
    city = db.relationship('City', backref=db.backref('citys', lazy='dynamic'))
    postion = db.Column(db.String(50))
    excerpt = db.Column(db.String(200))
    description = db.Column(db.Text)
    category_id  = db.Column(db.Integer, db.ForeignKey('Category.id'))
    category = db.relationship('Category', backref=db.backref('places', lazy='dynamic'))
    headimg = db.Column(db.Text)

    def dict_data_short(self):
        return {'id':self.id,'name':self.name,'postion':self.postion,'excerpt':self.excerpt,'category_id':self.category_id,'headimg':self.headimg}

    def dict_data(self):
        return {'id':self.id,'name':self.name,'postion':self.postion,'excerpt':self.excerpt,'description':self.description,'category_id':self.category_id,'headimg':self.headimg}

    def __repr__(self):
        return '<Places %r>' % (self.name)

class Category(db.Model):
    __tablename__ = 'Category'
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    name = db.Column(db.String(50), unique=True)

    def dict_data(self):
        return {'id':self.id,'name':self.name}

    def __init__(self, name=None):
            self.name = name

    def __repr__(self):
        return '<Category %r>' % (self.name)