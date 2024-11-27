import { createMaterialTopTabNavigator } from "@react-navigation/material-top-tabs"
import DirectTab from "./direct"
import GroupTab from "./group"

const Tab = createMaterialTopTabNavigator()

export default function HomeScreen() {
	return (
		<Tab.Navigator
			initialRouteName="Direct Tabs"
			screenOptions={{
				tabBarScrollEnabled: true,
				tabBarLabelStyle: { fontWeight: "600" },
				tabBarItemStyle: { width: "auto" },
				tabBarIndicatorStyle: { width: 0.6 },
			}}
		>
			<Tab.Screen name="Direct Tabs" component={DirectTab} />
			<Tab.Screen name="Group Tabs" component={GroupTab} />
		</Tab.Navigator>
	)
}
