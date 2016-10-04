dat = read.csv("cars-sample.csv", header = TRUE)
plot(Weight, MPG, col=adjustcolor(Manufacturer, alpha=0.5), pch=21, bg=adjustcolor(Manufacturer, alpha=0.5), cex=(Weight/2000))