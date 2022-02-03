from django.test import TestCase
from .models import User


class UserTestCase(TestCase):
    def test_user(self):
        username = 'user'
        u = User(username=username)
        self.assertEqual(u.username, username)
