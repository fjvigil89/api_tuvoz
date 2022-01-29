"""
======================================
Radar chart (aka spider or star chart)
======================================

This example creates a radar chart, also known as a spider or star chart [1]_.

Although this example allows a frame of either 'circle' or 'polygon', polygon
frames don't have proper gridlines (the lines are circles instead of polygons).
It's possible to get a polygon grid by setting GRIDLINE_INTERPOLATION_STEPS in
matplotlib.axis to the desired number of vertices, but the orientation of the
polygon is not aligned with the radial axes.

.. [1] https://en.wikipedia.org/wiki/Radar_chart
"""

import json
import opensmile
import sys


def smille_data(n, _path):    
    path=[_path]
    smile = opensmile.Smile(
        feature_set=opensmile.FeatureSet.ComParE_2016,
        feature_level=opensmile.FeatureLevel.Functionals,
        # feature_level=opensmile.FeatureLevel.LowLevelDescriptors,
        loglevel=2,
        logfile='smile.log',
    )
    
    # print("Procesing... " )    
    
    feature = smile.process_files(path)       
     
    rows=feature.iloc[0].tolist()[:n]
    #feature.to_csv(destinity+"train.csv")    
    columns = feature.columns[:n].tolist()
    
    #return columns, rows
    return json.dumps(columns), json.dumps(rows)


if __name__ == '__main__':   
    args = sys.argv[1:]
    
    N =int(args[0]) 
    path = args[1]

    data = smille_data(N, path)
    print(data)
    #sys.exit(smille_data(N, path))