import unittest
import logging
import os
from selenium import webdriver
from selenium.webdriver.common.keys import Keys

driver = webdriver.PhantomJS()
driver.get("http://www.python.org")
assert "Foo" in driver.title

driver.close()
