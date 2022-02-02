from django.test import TestCase
from .models import User

# Create your tests here.
class UserTestCase(TestCase):
    def test_user(self):
        username = 'user'
        u = User(username=username)
        self.assertEqual(u.username, username)