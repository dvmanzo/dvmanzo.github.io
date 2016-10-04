import matplotlib.pyplot as plt
import numpy as np
import csv

with open('cars-sample.csv') as csvfile:
    reader = csv.DictReader(csvfile)
    for row in reader:
        plt.scatter(row['Weight'], row['MPG'], s=(float(row['Weight'])/100), c=row['Manufacturer'], alpha=0.5)
        

plt.xlabel('MPG')
plt.ylabel('Weight')
plt.title('Python Implementation')
plt.axis([1000, 5200, 0, 50])
plt.xticks(np.arange(2000, 6000, 1000.0))
plt.yticks(np.arange(10, 50, 10.0))
plt.show();